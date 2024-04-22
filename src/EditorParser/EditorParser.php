<?php

declare(strict_types=1);

namespace MakeBlogLaravel\EditorParser;

use DOMDocument;
use DOMElement;
use DOMException;
use DOMText;
use Exception;
use Masterminds\HTML5;

class EditorParser
{
    private array $data;

    private DOMDocument $dom;

    private HTML5 $html5;

    private string $prefix = "prs";

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->dom = new DOMDocument('1.0', 'UTF-8');

        $this->html5 = new HTML5([
            'target_document' => $this->dom,
            'disable_html_ns' => true
        ]);
    }

    static function parse(array $data): EditorParser
    {
        return new self($data);
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    public function getBlocks(): ?array
    {
        return $this->data ?? null;
    }

    /**
     * @throws Exception
     */
    public function toHtml(): false|string
    {
        $this->init();

        return $this->dom->saveHTML();
    }

    /**
     * @throws Exception
     */
    private function init(): void
    {
        if (!$this->hasBlocks()) throw new Exception('No Blocks to parse !');

        foreach ($this->data as $block) {
            switch ($block['type']) {
                case 'table':
                    $this->parseTable($block);
                    break;
                case 'header':
                    $this->parseHeader($block);
                    break;
                case 'delimiter':
                    $this->parseDelimiter();
                    break;
                case 'code':
                    $this->parseCode($block);
                    break;
                case 'paragraph':
                    $this->parseParagraph($block);
                    break;
                case 'linkTool':
                    $this->parseLink($block);
                    break;
                case 'embed':
                    $this->parseEmbed($block);
                    break;
                case 'raw':
                    $this->parseRaw($block);
                    break;
                case 'list':
                    $this->parseList($block);
                    break;
                case 'warning':
                    $this->parseWarning($block);
                    break;
                case 'image':
                    $this->parseImage($block);
                    break;
                default:
                    break;
            }
        }
    }

    private function hasBlocks(): bool
    {
        return count($this->data) !== 0;
    }

    /**
     * @throws DOMException
     */
    private function parseTable($block): void
    {
        $withHeadings = $block['data']['withHeadings'];

        $table = $this->dom->createElement('table');
        $tableBody = $this->dom->createElement('tbody');

        if ($withHeadings) {
            $tableHead = $this->dom->createElement('thead');
            $table->appendChild($tableHead);
            $rowNode = $this->dom->createElement('tr');
            foreach ($block['data']['content'][0] as $cell) {
                $cellNode = $this->dom->createElement('th');
                $cellNode->appendChild($this->html5->loadHTMLFragment($cell));
                $rowNode->appendChild($cellNode);
            }
            $tableHead->appendChild($rowNode);
        }

        $table->appendChild($tableBody);

        foreach ($block['data']['content'] as $key => $row) {
            $idx = $withHeadings ? $key + 1 : $key;
            if (count($block['data']['content']) > $idx) {
                $rowNode = $this->dom->createElement('tr');
                foreach ($block['data']['content'][$idx] as $cell) {
                    $cellNode = $this->dom->createElement('td');
                    $cellNode->appendChild($this->html5->loadHTMLFragment($cell));
                    $rowNode->appendChild($cellNode);
                }
                $tableBody->appendChild($rowNode);
            }
        }

        $this->dom->appendChild($table);
    }

    /**
     * @throws DOMException
     */
    private function parseHeader($block): void
    {
        $text = new DOMText($block['data']['text']);

        $header = $this->dom->createElement('h' . $block['data']['level']);

        $header->setAttribute('class', "{$this->prefix}-h{$block['data']['level']}");

        $header->appendChild($text);

        $this->dom->appendChild($header);
    }

    /**
     * @throws DOMException
     */
    private function parseDelimiter(): void
    {
        $node = $this->dom->createElement('hr');

        $node->setAttribute('class', "{$this->prefix}-delimiter");

        $this->dom->appendChild($node);
    }

    /**
     * @throws DOMException
     */
    private function parseCode($block): void
    {
        $wrapper = $this->dom->createElement('div');

        $wrapper->setAttribute('class', "{$this->prefix}-code");

        $pre = $this->dom->createElement('pre');

        $code = $this->dom->createElement('code');

        $content = new DOMText($block['data']['code']);

        $code->appendChild($content);

        $pre->appendChild($code);

        $wrapper->appendChild($pre);

        $this->dom->appendChild($wrapper);
    }

    /**
     * @throws DOMException
     */
    private function parseParagraph($block): void
    {
        $node = $this->dom->createElement('p');

        $node->setAttribute('class', "{$this->prefix}-paragraph");

        $node->appendChild($this->html5->loadHTMLFragment($block['data']['text']));

        $this->dom->appendChild($node);
    }

    /**
     * @throws DOMException
     */
    private function parseLink($block): void
    {
        $link = $this->dom->createElement('a');

        $link->setAttribute('href', $block['data']['link']);
        $link->setAttribute('target', '_blank');
        $link->setAttribute('class', "{$this->prefix}-link");

        $innerContainer = $this->dom->createElement('div');
        $innerContainer->setAttribute('class', "{$this->prefix}-link-container");

        $hasTitle = isset($block['data']['meta']['title']);
        $hasDescription = isset($block['data']['meta']['description']);
        $hasImage = isset($block['data']['meta']['image']);

        if ($hasTitle) {
            $titleNode = $this->dom->createElement('div');
            $titleNode->setAttribute('class', "{$this->prefix}-link-title");
            $titleText = new DOMText($block['data']['meta']['title']);
            $titleNode->appendChild($titleText);
            $innerContainer->appendChild($titleNode);
        }

        if ($hasDescription) {
            $descriptionNode = $this->dom->createElement('div');
            $descriptionNode->setAttribute('class', "{$this->prefix}-link-description");
            $descriptionText = new DOMText($block['data']['meta']['description']);
            $descriptionNode->appendChild($descriptionText);
            $innerContainer->appendChild($descriptionNode);
        }

        $linkContainer = $this->dom->createElement('div');
        $linkContainer->setAttribute('class', "{$this->prefix}-link-url");
        $linkText = new DOMText($block['data']['link']);
        $linkContainer->appendChild($linkText);
        $innerContainer->appendChild($linkContainer);

        $link->appendChild($innerContainer);

        if ($hasImage) {
            $imageContainer = $this->dom->createElement('div');
            $imageContainer->setAttribute('class', "{$this->prefix}-link-img-container");
            $image = $this->dom->createElement('img');
            $image->setAttribute('src', $block['data']['meta']['image']['url']);
            $imageContainer->appendChild($image);
            $link->appendChild($imageContainer);
            $innerContainer->setAttribute('class', "{$this->prefix}-link-container-with-img");
        }

        $this->dom->appendChild($link);
    }

    /**
     * @throws DOMException
     */
    private function parseEmbed($block): void
    {
        $wrapper = $this->dom->createElement('div');

        $wrapper->setAttribute('class', "{$this->prefix}-embed");

        switch ($block['data']['service']) {
            case 'youtube':
                $attrs = [
                    'height' => $block['data']['height'],
                    'src' => $block['data']['embed'],
                    'allow' => 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture',
                    'allowfullscreen' => true
                ];
                $wrapper->appendChild($this->createIframe($attrs));
                break;
            case 'codepen':
            case 'gfycat':
                $attrs = [
                    'height' => $block['data']['height'],
                    'src' => $block['data']['embed'],
                ];
                $wrapper->appendChild($this->createIframe($attrs));
                break;
        }

        $this->dom->appendChild($wrapper);
    }

    /**
     * @throws DOMException
     */
    private function createIframe(array $attrs): DOMElement
    {
        $iframe = $this->dom->createElement('iframe');

        foreach ($attrs as $key => $attr) $iframe->setAttribute($key, $attr);

        return $iframe;
    }

    /**
     * @throws DOMException
     */
    private function parseRaw($block): void
    {
        $wrapper = $this->dom->createElement('div');

        $wrapper->setAttribute('class', "{$this->prefix}-raw");

        $wrapper->appendChild($this->html5->loadHTMLFragment($block['data']['html']));

        $this->dom->appendChild($wrapper);
    }

    /**
     * @throws DOMException
     */
    private function parseList($block): void
    {
        $wrapper = $this->dom->createElement('div');
        $wrapper->setAttribute('class', "{$this->prefix}-list");

        $list = match ($block['data']['style']) {
            'ordered' => $this->dom->createElement('ol'),
            default => $this->dom->createElement('ul'),
        };

        foreach ($block['data']['items'] as $item) {
            $li = $this->dom->createElement('li');
            $li->appendChild($this->html5->loadHTMLFragment($item));
            $list->appendChild($li);
        }

        $wrapper->appendChild($list);

        $this->dom->appendChild($wrapper);
    }

    /**
     * @throws DOMException
     */
    private function parseWarning($block): void
    {
        $title = new DOMText($block['data']['title']);
        $message = new DOMText($block['data']['message']);

        $wrapper = $this->dom->createElement('div');
        $wrapper->setAttribute('class', "{$this->prefix}-warning");

        $textWrapper = $this->dom->createElement('div');
        $titleWrapper = $this->dom->createElement('p');

        $titleWrapper->appendChild($title);
        $messageWrapper = $this->dom->createElement('p');

        $messageWrapper->appendChild($message);

        $textWrapper->appendChild($titleWrapper);
        $textWrapper->appendChild($messageWrapper);

        $icon = $this->dom->createElement('ion-icon');
        $icon->setAttribute('name', 'information-outline');
        $icon->setAttribute('size', 'large');

        $wrapper->appendChild($icon);
        $wrapper->appendChild($textWrapper);

        $this->dom->appendChild($wrapper);
    }

    /**
     * @throws DOMException
     */
    private function parseImage($block): void
    {
        $figure = $this->dom->createElement('figure');

        $figure->setAttribute('class', "{$this->prefix}-image");

        $img = $this->dom->createElement('img');

        $imgAttrs = [];

        if ($block['data']['withBorder']) $imgAttrs[] = "{$this->prefix}-image-border";
        if ($block['data']['withBackground']) $imgAttrs[] = "{$this->prefix}-image-background";
        if ($block['data']['stretched']) $imgAttrs[] = "{$this->prefix}-image-stretched";

        $img->setAttribute('src', $block['data']['url']);
        $img->setAttribute('alt', $block['data']['caption']);
        $img->setAttribute('class', implode(' ', $imgAttrs));

        $figure->appendChild($img);

        $this->dom->appendChild($figure);
    }
}
