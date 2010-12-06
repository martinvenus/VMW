<?php

/**
 * MI-VMW
 *
 * @package    MI-VMW
 */

/**
 * Homepage presenter.
 *
 * @author     Martin Venuš, Jaroslav Líbal
 * @package    MI-VMW, semestral project
 */
class HomepagePresenter extends BasePresenter {

    public function actionSearch($keyword, $color = 'black', $raster = 10, $numberOfPhoto = 20) {
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

        $this->template->data = $photos;
    }

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

        $form->addSubmit('search', 'Vyhledat');
        $form->onSubmit[] = callback($this, 'processMainForm');

        return $form;
    }

    public function processMainForm(NAppForm $form) {
        if ($form['search']->isSubmittedBy()) {

            $data = $form->getValues(); // vezmeme data z formuláře

            $this->redirect('search', $data['keyword'], $data['color'], $data['raster'], $data['numberOfPhoto']);
        }

        $this->redirect('Homepage:default');
    }

}