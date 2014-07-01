<?php
/**
 * configuration_helper.php
 *
 * This helper script generates the .htaccess and css lines for the 
 * icon and description configuration of the different file types.
 * It also sets the correct include paths for the header and footer.
 *
 * @copyright  Copyright (c) 2014 Finn Rudolph (http://finnrudolph.de)
 * @license    http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
 * @author     Finn Rudolph <finn.rudolph@gmail.com>
 */

/* Get the root path from the environment variable set in the .htaccess file. */
$rootPath = getenv('ROOT_PATH');

/* Configuration settings. */
$newLine = "\n";
$indent = '    ';
$colors = array('#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
                '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
                '#f1c40f', '#e67e22', '#e74c3c', '#95a5a6', '#95a5a6',
                '#d35400', '#d35400', '#c0392b', '#bdc3c7', '#7f8c8d');   

/* Parse the CSV file into an array. */
$fileTypes = array();
$csv = file_get_contents('file_types.csv');
$lines = str_getcsv($csv, $newLine);
foreach($lines as $line)
{
    $fileTypes[] =  str_getcsv($line, ';', '');
}

/* Generate the .htaccess part. */
$htaccess = $indent . '# Set absolute paths to header and footer files.' . $newLine
          . $indent . 'HeaderName ' . $rootPath . '/public/header.phtml' . $newLine
          . $indent . 'ReadmeName ' . $rootPath . '/public/footer.phtml' . $newLine
          . $newLine
          . $indent . '# Ignore all files in the public directory.' . $newLine
          . $indent . 'IndexIgnore ' . $rootPath . '/public' . $newLine
          . $newLine
          . $indent . '# Overwrite the default icons with a placeholder.' . $newLine
          . $indent . 'AddIcon (blank,' . $rootPath . '/public/placeholder.png) ^^BLANKICON^^' . $newLine
          . $indent . 'AddIcon (directory,' . $rootPath . '/public/placeholder.png) ^^DIRECTORY^^' . $newLine
          . $indent . 'AddIcon (directory-parent,' . $rootPath . '/public/placeholder.png) ..' . $newLine
          . $newLine
          . $indent . '# Add file type icons and descriptions.' . $newLine
          ;

foreach($fileTypes as $fileType)
{
    $htaccess .= $indent . 'AddDescription "' . $fileType[2] . '" .' . $fileType[1] . $newLine;
    $htaccess .= $indent . 'AddIcon (' . $fileType[0] . $fileType[1] . ',' . $rootPath . '/public/placeholder.png) .' . $fileType[1] . $newLine;
}

/* Generate the CSS background part. */
$colorIndex = 0;
$colorMax = count($colors);
$cssBackground = '';
$fileTypePrefixes = array();
foreach($fileTypes as $fileType)
{
    $fileTypePrefixes[] = $fileType[0];
}
$uniqueFileTypePrefixes = array_unique($fileTypePrefixes);
foreach($uniqueFileTypePrefixes as $fileTypePrefix)
{
    if($colorIndex === $colorMax)
    {
        $colorIndex = 0;
    }
    
    $cssBackground .= $indent . 'td[data-icon^="[' . $fileTypePrefix . '"]:after { background: ' . $colors[$colorIndex] . ' }' . $newLine;
    
    
    $colorIndex++;
}

/* Generate the CSS content part. */
$cssContent = '';
foreach($fileTypes as $fileType)
{
    $content = (strlen($fileType[1]) < 5) ? $fileType[1] : substr($fileType[1], 0 , 3) . '&hellip;';
    
    $cssContent .= $indent . 'td[data-icon="[' . $fileType[0] . $fileType[1] . ']"]:after { content: "' . $content . '" }' . $newLine;
}

?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>File Types &mdash; Responsive Apache Directory Listing</title>    
        <meta name="keywords" content="responsive, apache, webserver, .htaccess, directory listing, css, webfont">
        <meta name="description" content="Helper script for a responsive Apache directory listing.">
        <meta name="author" content="Finn Rudolph">
        <meta name="robots" content="index, follow, noarchive">
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <link rel="shortcut icon" href="favicon.ico"/>
        <style type="text/css">
            
            * {
                margin: 0;
                padding: 0;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            main,
            header,
            section,
            footer {
                display: block;
            }
            html {
                width: 100%;
                height: 100%;
                font-size: 100%;
                background: #eee;
                padding: 1rem;
            }
            textarea {
                width: 100%;
            }
            h1, 
            h2,
            footer {
                margin: 1rem 0;
            }
            
        </style>
    </head>
	<body>
        <main>
            <h1>Configuration Helper</h1>
            <section>
                <header>
                    <h2>.htaccess</h2>
                </header>
                <textarea cols="100" rows="8" ><?php echo $htaccess; ?></textarea>
            </section>
            <section>
                <header>
                    <h2>public/all.css</h2>
                </header>
                <textarea cols="100" rows="8" ><?php echo $cssBackground . $cssContent; ?></textarea>
            </section>
        </main>
        <footer>
            Copyright&nbsp;© 2006&nbsp;–&nbsp;<?php  echo date('Y') ?> <a href="http://finnrudolph.com/legal-disclosure"><em>Finn&nbsp;Rudolph</em></a>. All&nbsp;rights&nbsp;reserved.
        </footer>
    </body>
</html>