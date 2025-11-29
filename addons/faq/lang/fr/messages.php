<?php

return [
    'settings' => [
        'title' => 'FAQ',
        'description' => 'Permet de gérer vos FAQ.',
    ],
    'index' => [
        'title' => 'Gestion des FAQ',
        'description' => 'Liste des questions / réponses du système.',
        'table' => [
            'title' => 'Titre',
            'group' => 'Groupe', 
            'product' => 'Produit',
        ]
    ],
    'faq' => [
        'create' => 'Vous avez bien créer votre FAQ.',
        'update' => 'Vous avez bien mis à jour votre FAQ.',
        'delete' => 'Vous avez bien supprimer votre FAQ.'
    ],
    'create' => [
        'title' => 'Créer votre FAQ',
        'description' => 'Permet de créer votre FAQ.',
    ],
    'update' => [
        'title' => 'Modification d\'une FAQ',
        'description' => 'Modifie votre FAQ.',
    ],
    'formulaire' => [
        'title' => 'Titre',
        'group' => 'Groupe',
        'product' => 'Produit',
        'none' => 'Aucun',
        'group_help' => 'Laissez vide pour rendre la FAQ générale ou ciblée sur un produit.',
        'product_help' => 'Optionnel : ciblez un produit précis. La FAQ sera affichée dans la page de configuration du produit lors de la commande.',
        'answer' => 'Votre réponse',
    ],
    'stats' => [
        'title' => 'Utilité de la question',
        'description' => 'Synthèse des votes oui / non laissés par les clients.',
    ],
    'client' => [
        'title' => 'FAQ',
        'description' => 'Réponses aux questions les plus fréquemment posées.',
        'general_title' => 'FAQ générale',
        'general_description' => 'Retrouvez les réponses aux questions que l\'on nous pose le plus souvent.',
        'group_title' => 'FAQ - :name',
        'group_description' => 'Toutes les réponses liées au groupe :name.',
        'product_title' => 'FAQ pour :name',
        'product_description' => 'Tout ce qu\'il faut savoir avant de commander :name.',
        'cta_text' => 'Toujours besoin d\'aide ? Notre support est là pour vous.',
        'cta_button' => 'Contacter le support',
        'useful_prompt' => 'Cette réponse vous a-t-elle été utile ?',
        'useful_yes' => 'Oui',
        'useful_no' => 'Non',
        'useful_stats_template' => ':percent% des clients ont trouvé cette réponse utile (:yes/:total).',
        'useful_stats_template_raw' => ':percent% des clients ont trouvé cette réponse utile (:yes/:total).',
        'feedback_positive' => 'Merci pour votre retour !',
        'feedback_negative' => 'Merci ! Nous allons améliorer cette réponse.',
        'feedback_error' => 'Impossible d\'enregistrer votre avis, veuillez réessayer plus tard.',
        'empty' => 'Aucune FAQ disponible pour le moment.',
    ],
];
