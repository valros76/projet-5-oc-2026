<?php
class CSV
{

   public static function createAndDownloadFile(string $filename, array|object|string $datas, array|null $csv_header = null)
   {
      // Create csv filename
      $filename = str_replace(".csv", "", $filename);
      $newFilename = Format::formatFilename($filename) . ".csv";
      // Create csv file
      $file = fopen($newFilename, "w");
      // Import datas in csv file
      if(!is_null($csv_header)){
         fputcsv($file, $csv_header, ";");
      }
      foreach (json_decode(json_encode($datas), true) as $line) {
         fputcsv($file, $line, ";");
      }
      // Close csv file
      fclose($file);
      // Download file
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=" . $newFilename);
      header("Content-Type: application/csv;");
      // Read csv file
      readfile($newFilename);
      // Deleting file
      unlink($newFilename);
      exit();
   }
   
   public static function createAndReadFile(string $filename, array|object|string $datas, array|null $csv_header = null)
   {
      // Create csv filename
      $filename = str_replace(".csv", "", $filename);
      $newFilename = Format::formatFilename($filename) . ".csv";
      // Create csv file
      $file = fopen("php://temp/maxmemory:1048576", "w");
      // Import datas in csv file
      if(!is_null($csv_header)){
         fputcsv($file, $csv_header, ";");
      }
      foreach (json_decode(json_encode($datas), true) as $line) {
         fputcsv($file, $line, ";");
      }
      // Return to the document start
      rewind($file);
      // File content read in variable
      $csv = stream_get_contents($file);
      // Close csv file
      fclose($file);
      return $csv;
   }
   
   public static function createAndSaveFile(string $filename, array|object|string $datas, array|null $csv_header = null)
   {
      // Create csv filename
      $filename = str_replace(".csv", "", $filename);
      $newFilename = Format::formatFilename($filename) . ".csv";
      // Create assets/download DIR if not exists
      if(is_dir("assets/download") === false){
         mkdir("assets/download", 0700);
      }
      // Create assets/download/csv DIR if not exists
      if(is_dir("assets/download/csv") === false){
         mkdir("assets/download/csv", 0700);
      }
      $file_dir = "assets/download/csv/$filename.csv";
      // Create csv file
      $file = fopen($file_dir, "w");
      // Import datas in csv file
      if(!is_null($csv_header)){
         fputcsv($file, $csv_header, ";");
      }
      foreach (json_decode(json_encode($datas), true) as $line) {
         fputcsv($file, $line, ";");
      }
      // Close csv file
      fclose($file);
      return $file_dir;
   }
}
