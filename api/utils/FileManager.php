<?php
class FileManager
{
  private $listJsFile;
  private $listCssFile;

  public function __construct()
  {
    $this->listJsFile = [];
    $this->listCssFile = [];
  }

  public function addJs($file)
  {
    $this->listJsFile[] = $file;
  }

  public function addCss($file)
  {
    $this->listCssFile[] = $file;
  }

  public function generateJs()
  {
    $jsContent = "";
    foreach ($this->listJsFile as $jsFile) {
      $jsContent .= "<script src=\"{$jsFile}\"></script>";
    }
    return $jsContent;
  }

  public function generateCss()
  {
    $cssContent = '';
    foreach ($this->listCssFile as $cssFile) {
      $cssContent .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssFile}\" />";
    }
    return $cssContent;
  }
}
