<?php

namespace App\Addons\Faq\Database\Seeders;

use App\Addons\Faq\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        if (Faq::count() > 0) {
            return;
        }
        $faqs = [
            [
                'title' => 'Comment créer un compte ?',
                'answer' => "Cliquez sur « S'inscrire » dans l'en-tête, remplissez vos informations puis validez votre adresse email.",
            ],
            [
                'title' => 'Où voir et payer mes factures ?',
                'answer' => 'Rendez-vous dans votre espace client, section Factures, puis choisissez un mode de paiement disponible.',
            ],
            [
                'title' => 'Puis-je changer d’offre plus tard ?',
                'answer' => 'Oui, vous pouvez mettre à niveau ou rétrograder votre offre depuis la page de gestion du service.',
            ],
            [
                'title' => 'Comment contacter le support ?',
                'answer' => 'Ouvrez un ticket depuis votre espace client ou utilisez le chat en bas à droite pour les urgences.',
            ],
            [
                'title' => 'Proposez-vous une période d’essai ?',
                'answer' => "Selon le produit, une période d'essai peut être proposée. Consultez la page produit ou contactez le support.",
            ],
        ];

        foreach ($faqs as $index => $data) {
            Faq::firstOrCreate(
                ['title' => $data['title']],
                [
                    'answer' => $data['answer'],
                    'order' => $index + 1,
                ]
            );
        }
    }
}
