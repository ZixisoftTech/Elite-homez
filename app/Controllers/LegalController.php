<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;

class LegalController extends Controller {
    public function privacy(): void {
        AppBootstrap::init();
        $seo = [
            'title' => 'Privacy Policy | Elite Homez',
            'description' => 'Data protection and confidentiality policy for clients and visitors of Elite Homez real estate advisory.',
            'canonical' => '/privacy-policy'
        ];
        $this->render('legal/privacy', ['seo' => $seo]);
    }

    public function terms(): void {
        AppBootstrap::init();
        $seo = [
            'title' => 'Terms of Engagement & Advisory Disclaimer | Elite Homez',
            'description' => 'Terms of service, client representation terms, and statutory property advisory disclaimers for Elite Homez.',
            'canonical' => '/terms-and-disclaimer'
        ];
        $this->render('legal/terms', ['seo' => $seo]);
    }
}
