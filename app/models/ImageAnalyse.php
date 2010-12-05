<?php

class ImageAnalyse extends NObject {

    /**
     * This function accepts a truecolor image object and analyzes the colors.
     * It works by dividing the image into x*y blocks and identifying the dominant color in each
     * block. It returns these colors in an array in the format array[xPos][yPos]
     * @author Ben Hindmarch
     * @copyright 2007
     * @version 0.2 (2007-06-26)
     * @abstract Grabs the main colors from an image
     * @param binary $im The image object
     * @param integer $xCount The number of blocks along the x-axis (default 3)
     * @param integer $yCount The number of blocks along the y-axis (default 3)
     * @return array containing x and y position of color, individual decimal red, green and blue
     * values as well as a hex value
     */
    public static function analyzeImageColors($im, $xCount = 3, $yCount = 3) {
//get dimensions for image
        $imWidth = imagesx($im);
        $imHeight = imagesy($im);

//find out the dimensions of the blocks we're going to make
        $blockWidth = round($imWidth / $xCount);
        $blockHeight = round($imHeight / $yCount);
//now get the image colors...
        for ($x = 0; $x < $xCount; $x++) { //cycle through the x-axis
            for ($y = 0; $y < $yCount; $y++) { //cycle through the y-axis
//this is the start x and y points to make the block from
                $blockStartX = ($x * $blockWidth);
                $blockStartY = ($y * $blockHeight);
//create the image we'll use for the block
                $block = imagecreatetruecolor(1, 1);
//We'll put the section of the image we want to get a color for into the block
                imagecopyresampled($block, $im, 0, 0, $blockStartX, $blockStartY, 1, 1, $blockWidth, $blockHeight);
//the palette is where I'll get my color from for this block
                imagetruecolortopalette($block, true, 1);
//I create a variable called eyeDropper to get the color information
                $eyeDropper = @imagecolorat($block, 1, 1);
                $palette = imagecolorsforindex($block, $eyeDropper);
                $colorArray[$x][$y]['r'] = $palette['red'];
                $colorArray[$x][$y]['g'] = $palette['green'];
                $colorArray[$x][$y]['b'] = $palette['blue'];
//get the rgb value too
                $hex = sprintf("%02X%02X%02X", $colorArray[$x][$y]['r'], $colorArray[$x][$y]['g'], $colorArray[$x][$y]['b']);
                $colorArray[$x][$y]['rgbHex'] = $hex;
//destroy the block
                imagedestroy($block);
            }
        }
//destroy the source image
        imagedestroy($im);
        return $colorArray;
    }

}