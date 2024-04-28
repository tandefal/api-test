<?php

namespace App\controllers;

use cebe\markdown\GithubMarkdown;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{

    public function index(): Response
    {
        $path = realpath('');
        $documentationContent = file_get_contents($path . '/documentation.md');
        $parser = new GithubMarkdown();
        $documentationHtml = $parser->parse($documentationContent);
        $content = <<<CONTENT
            <head>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown.min.css' type='text/css' media='all' />
                <style>
                    .markdown-body {
                        box-sizing: border-box;
                        min-width: 200px;
                        max-width: 1360px;
                        margin: 0 auto;
                        padding: 45px;
                    }

                    @media (max-width: 767px) {
                        .markdown-body {
                            padding: 15px;
                        }
                    }
                </style>
            </head>
            <body>
                <article class='markdown-body'>
                    {$documentationHtml}
                </article>
            </body>
CONTENT;

        return new Response($content);
    }
}