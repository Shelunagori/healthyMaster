<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;

class FaqsController extends AppController
{
    public function initialize()
     {
         parent::initialize();
     }

     public function faqdata()
     {
       $faqData = [];
              $faqData = $this->Faqs->find()->where(['status'=>0]);
              if(!empty($faqData->toArray()))
              {
                $status = true;
                $error = 'Faq Found Successfully';
              }else {
                $status = false;
                $error = 'No Data Found';
              }
       $this->set(['status' => $status,'error'=>$error,'faqdata' => $faqData,'_serialize' => ['status','error','faqdata']]);
     }
}
