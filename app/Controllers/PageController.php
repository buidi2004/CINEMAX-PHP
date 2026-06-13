<?php
namespace App\Controllers;

class PageController extends BaseController
{
    public function careers()
    {
        $this->render('pages.careers', ['pageTitle' => 'Tuyển dụng - CinemaX']);
    }

    public function partners()
    {
        $this->render('pages.partners', ['pageTitle' => 'Dành cho đối tác - CinemaX']);
    }

    public function terms()
    {
        $this->render('pages.terms', ['pageTitle' => 'Điều khoản chung - CinemaX']);
    }

    public function termsTransaction()
    {
        $this->render('pages.terms_transaction', ['pageTitle' => 'Điều khoản giao dịch - CinemaX']);
    }

    public function paymentPolicy()
    {
        $this->render('pages.payment_policy', ['pageTitle' => 'Chính sách thanh toán - CinemaX']);
    }

    public function privacyPolicy()
    {
        $this->render('pages.privacy_policy', ['pageTitle' => 'Chính sách bảo mật - CinemaX']);
    }

    public function cinemaRules()
    {
        $this->render('pages.cinema_rules', ['pageTitle' => 'Quy định tại rạp - CinemaX']);
    }

    public function faq()
    {
        $this->render('pages.faq', ['pageTitle' => 'Câu hỏi thường gặp - CinemaX']);
    }
}
