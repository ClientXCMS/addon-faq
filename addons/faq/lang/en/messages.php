<?php

return [
    'settings' => [
        'title' => 'FAQ',
        'description' => 'Manage your FAQs.',
    ],
    'index' => [
        'title' => 'FAQ Management',
        'description' => 'List of system questions and answers.',
        'table' => [
            'title' => 'Title',
            'group' => 'Group', 
            'product' => 'Product',
            'create' => 'Created at', 
            'action' => 'Actions'
        ]
    ],
    'faq' => [
        'create' => 'Your FAQ has been successfully created.',
        'update' => 'Your FAQ has been successfully updated.',
        'delete' => 'Your FAQ has been successfully deleted.'
    ],
    'create' => [
        'title' => 'Create FAQ',
        'description' => 'Create a new FAQ.',
    ],
    'update' => [
        'title' => 'Edit FAQ',
        'description' => 'Update your FAQ.',
    ],
    'formulaire' => [
        'title' => 'Title',
        'group' => 'Group',
        'product' => 'Product',
        'none' => 'None',
        'group_help' => 'Leave empty to display the FAQ globally or for a product.',
        'product_help' => 'Optional: target a specific product instead of a full group.',
        'answer' => 'Your answer',
    ],
    'bouton' => [
        'update' => 'Update',
    ],
    'client' => [
        'title' => 'FAQ',
        'description' => 'Answers to the most frequently asked questions.',
        'general_title' => 'General FAQ',
        'general_description' => 'Find answers to the recurring questions we receive most often.',
        'group_title' => 'FAQ - :name',
        'group_description' => 'All the answers related to the :name group.',
        'product_title' => 'FAQ for :name',
        'product_description' => 'Everything you need to know before ordering :name.',
        'cta_text' => 'Still looking for help? Our support team is here for you.',
        'cta_button' => 'Contact support',
        'useful_prompt' => 'Was this answer helpful?',
        'useful_yes' => 'Yes',
        'useful_no' => 'No',
        'useful_stats_template' => ':percent% of customers found this answer helpful (:yes/:total).',
        'useful_stats_template_raw' => ':percent% of customers found this answer helpful (:yes/:total).',
        'feedback_positive' => 'Thanks for your feedback!',
        'feedback_negative' => 'Thanks! We will use your feedback to improve this answer.',
        'feedback_error' => 'Unable to save your feedback, please try again later.',
        'empty' => 'No FAQ available for the moment.',
    ],
];
