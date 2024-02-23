use std::{fmt::Display, fs, io::Write, path::Path};

use anyhow::{anyhow, Result};
use clap::{Parser, Subcommand, ValueEnum};

#[derive(Parser)]
#[command(version, about, long_about = None)]
struct Args {
    #[arg(short, long)]
    command: Command,

    #[arg(long, default_value_t = FileType::Unknown)]
    file_type: FileType,

    #[arg(long, default_value_t = String::from(""))]
    file_name: String,
}

#[derive(Subcommand, Debug, Clone, ValueEnum)]
enum Command {
    #[clap(name = "create")]
    Create,
}

#[derive(Subcommand, Debug, Clone, ValueEnum)]
enum FileType {
    #[clap(name = "controller")]
    Controller,

    #[clap(name = "model")]
    Model,

    #[clap(name = "unknown")]
    Unknown,
}

impl Display for FileType {
    fn fmt(&self, f: &mut std::fmt::Formatter<'_>) -> std::fmt::Result {
        write!(f, "{}", format!("{:?}", self).to_lowercase())
    }
}

fn main() -> Result<()> {
    let args = Args::parse();

    match args.command {
        Command::Create => create(args)?,
    }

    Ok(())
}

fn create(args: Args) -> Result<()> {
    if args.file_name.is_empty() {
        return Err(anyhow!("File name is required"));
    }

    match args.file_type {
        FileType::Controller => {
            create_controller(args.file_name.to_owned())?;
        }
        FileType::Model => create_model(args.file_name.to_owned())?,
        _ => return Err(anyhow!("Unknown file type")),
    }

    Ok(())
}

fn write_to_file(file_name: String, content: String) -> Result<()> {
    let mut file = fs::File::create(file_name)?;
    file.write_all(content.as_bytes())?;
    Ok(())
}

fn create_controller(controller_name: String) -> Result<()> {
    let path = Path::new(controller_name.as_str());
    let filename = path.file_stem().unwrap().to_str().unwrap();
    let dirname = path.parent().unwrap().to_str().unwrap();

    let content = format!(
        r#"<?php

namespace App\Controllers{};
    
include lib_controllers_url . 'Controller.php';

use Lib\Systems\Controllers\Controller;

class {}Controller extends Controller
{{
    public function index()
    {{
    }}
}}
    "#,
        if dirname.is_empty() {
            String::new()
        } else {
            format!("\\{}", dirname)
        },
        filename
    );

    let directory_path = format!("app/controllers/{}", dirname);
    fs::create_dir_all(&directory_path)?;

    let fullpath = format!("app/controllers/{}Controller.php", controller_name);
    write_to_file(fullpath.to_owned(), content)?;

    println!(
        "-- created Controller as {}Controller at {} --",
        controller_name, fullpath
    );

    Ok(())
}

fn create_model(model_name: String) -> Result<()> {
    let path = Path::new(model_name.as_str());
    let filename = path.file_stem().unwrap().to_str().unwrap();
    let dirname = path.parent().unwrap().to_str().unwrap();

    let content = format!(
        r#"<?php

namespace App\Models{};
    
include lib_models_url . 'Model.php';

use Lib\Systems\Models\Model;

class {}Model extends Model
{{
    protected $primary_key = 'id';
}}
    "#,
        if dirname.is_empty() {
            String::new()
        } else {
            format!("\\{}", dirname)
        },
        filename
    );

    let directory_path = format!("app/models/{}", dirname);
    fs::create_dir_all(directory_path)?;

    let fullpath = format!("app/models/{}Model.php", model_name);
    write_to_file(fullpath.to_owned(), content)?;

    println!("-- created Model as {}Model at {} --", model_name, fullpath);

    Ok(())
}
