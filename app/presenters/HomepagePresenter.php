<?php
/**
 * Flickr - feature-based reranking
 * MI-VMW at CZECH TECHNICAL UNIVERSITY IN PRAGUE
 *
 * @copyright  Copyright (c) 2010
 * @package    VMW
 * @author     Jaroslav Líbal, Martin Venuš
 */

/**
 *
 * HomepagePresenter
 *
 */
class HomepagePresenter extends BasePresenter {

    /**
     * Metoda, která získá obrázky z Flickr API, aplikuje analýzu barev a
     * zobrazí výsledky
     * @param String $keyword klíčové slovo
     * @param String $color hledaná barva
     * @param int $raster počet částí na které je obrázek rozdělen (pro vyhledávání dominantní barvy)
     * @param int $numberOfPhoto počet fotografií, které budou staženy z FlickrAPI
     * @param int $photoPercentage kolik procent dané barvy musí fotografie obsahovat aby byla zobrazena
     *
     * Poznámky:
     * $raster určuje počet částí v horizontální (vertikální) části obrázku - tzn. ve skutečnosti bude obrázek rozdělen na $raster^2
     * $numberOfPhoto je počet obrázků, které Flickr vrátí. Některé z nich však
     * nejsou k dispozici v dostatečném rozlišení a proto nejsou pro barevnou analýzu
     * použity
     */
    public function actionSearch($keyword, $color = 'black', $raster = 10, $numberOfPhoto = 20, $photoPercentage = 0) {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $photos = $f->photos_search(array("tags" => $keyword, "tag_mode" => "any", "sort" => "relevance", "media" => "photos", "per_page" => $numberOfPhoto));

        foreach ($photos['photo'] as $key => $photo) {
            $sizes = $f->photos_getSizes($photo['id']);

            $isLarge = false;
            foreach ($sizes as $size) {
                if (strcmp($size['label'], 'Large') == 0) {
                    $isLarge = true;
                    break;
                }
            }

            if ($isLarge == false) {

                unset($photos['photo'][$key]);
            }
        }

        foreach ($photos['photo'] as $key => $photo) {

            $photo_path = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "_b.jpg";

            $percentage = ImageAnalyse::getColorPercentage($photo_path, $color, $raster, $raster);

            $photos['photo'][$key]['percentage'] = $percentage;
        }


        usort($photos['photo'], 'ImageAnalyse::compare');

        $this->template->photoPercentage = $photoPercentage;
        $this->template->data = $photos;
    }

    /**
     * Komponenta - formulář
     * @return NAppForm formulář
     */
    public function createComponentMainForm() {
        $form = new NAppForm;
        $form->addText('keyword', 'Klíčové slovo:')
                ->addRule(NForm::FILLED, 'Musíte vyplnit klíčové slovo!');
        $form->addSelect('color', 'Barva:', array(
            'black' => 'černá',
            'blue' => 'modrá',
            'brown' => 'hnědá',
            'gray' => 'šedá',
            'green' => 'zelená',
            'orange' => 'oranžová',
            'pink' => 'růžová',
            'red' => 'červená',
            'violet' => 'fialová',
            'white' => 'bílá',
            'yellow' => 'žlutá'
        ));

        $form->addSelect('raster', 'Rastr:', array(
            5 => 5,
            10 => 10,
            15 => 15,
            20 => 20,
            25 => 25,
            30 => 30,
            35 => 35,
            40 => 40,
            45 => 45,
            50 => 50,
        ));

        $form->addSelect('numberOfPhoto', 'Počet fotografií:', array(
            5 => 5,
            10 => 10,
            15 => 15,
            20 => 20,
            25 => 25,
            30 => 30,
            35 => 35,
            40 => 40,
            45 => 45,
            50 => 50,
        ));

        $form->setDefaults(array('raster'=>20, 'numberOfPhoto'=>20));

        for($i=0; $i<=100; $i++){
            $photoPercentage[$i - 1] = $i;
        }

        $form->addSelect('photoPercentage', 'Procent dané barvy pro zobrazení fotografie:', $photoPercentage);

        $form->addSubmit('search', 'Vyhledat');
        $form->onSubmit[] = callback($this, 'processMainForm');

        return $form;
    }

    /**
     * Zpracování odeslaného formuláře
     * @param NAppForm $form odeslaný formulář
     */
    public function processMainForm(NAppForm $form) {
        if ($form['search']->isSubmittedBy()) {

            $data = $form->getValues(); // vezmeme data z formuláře

            $this->redirect('search', $data['keyword'], $data['color'], $data['raster'], $data['numberOfPhoto'], $data['photoPercentage']);
        }

        $this->redirect('Homepage:default');
    }

}