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

    public function actionSearch($keyword, $color = 'black') {
        $f = new FlickrModel("eb01c6c4e23a0f036988692a7f42dd14");

        $recent = $f->photos_search(array("tags" => $keyword, "tag_mode" => "any", "sort" => "relevance", "media" => "photos", "per_page" => 20));

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

        foreach ($recent['photo'] as $key => $photo) {

            $file = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "_b.jpg";

            $percetage = ImageAnalyse::getColorPercentage($file, $color, 50, 50);

            $recent['photo'][$key]['percentage'] = $percetage;
        }

        $this->template->data = $recent;
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

    public function processMainForm(NAppForm $form) {
        if ($form['search']->isSubmittedBy()) {

            $data = $form->getValues(); // vezmeme data z formuláře

            $this->redirect('search', $data['keyword'], $data['color']);
        }

        $this->redirect('Homepage:default');
    }

}