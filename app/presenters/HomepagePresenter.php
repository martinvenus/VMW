<?php

/**
 * My NApplication
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class HomepagePresenter extends BasePresenter {

    public function renderDefault() {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $recent = $f->photos_search(array("tags" => "prague", "tag_mode" => "any", "sort" => "relevance", "media" => "photos", "per_page" => 10));

        foreach ($recent['photo'] as $key => $photo) {
            $sizes = $f->photos_getSizes($photo['id']);

            $isLarge = false;
            foreach ($sizes as $size) {
                if (strcmp($size['label'], 'Large') == 0) {
                    $isLarge = true;
                    break;
                }
            }

            if ($isLarge == false) {

                unset($recent['photo'][$key]);
            }
        }

        $this->template->data = $recent;
    }

    public function actionForm(){
        
    }

    public function createComponentMainForm() {
        $form = new NAppForm;
        $form->addText('keyword', 'Klíčové slovo:')
                ->addRule(NForm::FILLED, 'Musíte vyplnit klíčové slovo!');
        $form->addSelect('color', 'Barva:', array(
            'black' => 'Černá',
            'white' => 'Bílá',
        ));
        $form->addSubmit('search', 'Vyhledat');
        $form->onSubmit[] = callback($this, 'processMainForm');

        return $form;
    }

    public function processTodoForm(AppForm $form) {
        if ($form['search']->isSubmittedBy()) {
            // zpracuj
        }
        // redirectni
    }

    public function actionTest() {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $recent = $f->photos_search(array("tags" => "český krumlov", "tag_mode" => "any", "sort" => "interestingness-asc"));

        foreach ($recent['photo'] as $photo) {

            $file = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "_b.jpg";

            //$obrazek = NImage::fromFile($file);

            break;
        }

        $dimX = 5;
        $dimY = 5;

        $source_id = imageCreatefromjpeg($file);
        $data = ImageAnalyse::analyzeImageColors($source_id, $dimX, $dimY);
        //print_r($data);

        $datax = dibi::dataSource('SELECT * FROM color');

        $datax = $datax->fetchAll();

        //print_r($datax);

        for ($i = 0; $i < $dimX; $i++) {
            for ($j = 0; $j < $dimY; $j++) {

                $distance_min = 1000000000000;
                $barvickaId = 0;

                foreach ($datax as $color_db) {
                    $rozdil_r = $data[$i][$j]['r'] - $color_db['red'];
                    $rozdil_g = $data[$i][$j]['g'] - $color_db['green'];
                    $rozdil_b = $data[$i][$j]['b'] - $color_db['blue'];

                    $distance = pow($rozdil_r, 2) + pow($rozdil_g, 2) + pow($rozdil_b, 2);

                    if ($distance < $distance_min) {
                        $distance_min = $distance;
                        $barvickaId = $color_db['html'];
                    }
                }


                echo $distance_min;
                echo "<br />";
                echo $barvickaId;
                echo "<br />";
                echo "<br />";
            }
        }
    }

}
