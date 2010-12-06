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

    public function actionXXX() {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $recent = $f->photos_search(array("tags" => "český krumlov", "tag_mode" => "any", "sort" => "relevance", "media" => "photos", "per_page" => 20));

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

                //$this->redirect('Homepage:default', ($page + 1));
                unset($recent['photo'][$key]);
            }
        }

        $this->template->data = $recent;
    }

    public function actionDefault($color = 'red') {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $recent = $f->photos_search(array("tags" => "český krumlov", "tag_mode" => "any", "sort" => "relevance", "media" => "photos", "per_page" => 50));

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

        foreach($recent['photo'] as $key=>$photo) {

            $file = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "_b.jpg";

            $percetage = ImageAnalyse::getColorPercentage($file, $color, 50, 50);

            $recent['photo'][$key]['percentage'] = $percetage;
        }

        $this->template->data = $recent;
    }

}
