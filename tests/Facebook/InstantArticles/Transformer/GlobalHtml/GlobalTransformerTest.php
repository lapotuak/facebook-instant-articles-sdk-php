<?hh //decl
/**
 * Copyright (c) 2016-present, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 */
namespace Facebook\InstantArticles\Transformer\GlobalHtml;

use Facebook\InstantArticles\Transformer\Transformer;
use Facebook\InstantArticles\Elements\InstantArticle;

class GlobalTransformerTest extends \Facebook\Util\BaseHTMLTestCase
{
    public function testSelfTransformerContent()
    {
        date_default_timezone_set('UTC');

        $json_file = file_get_contents(__DIR__ . '/global-rules.json');

        $instant_article = InstantArticle::create();
        $transformer = new Transformer();
        $transformer->loadRules($json_file);

        $html_file = file_get_contents(__DIR__ . '/global.html');

        $transformer->transformString($instant_article, $html_file);
        $instant_article->addMetaProperty('op:generator:version', '1.0.0');
        $instant_article->addMetaProperty('op:generator:transformer:version', '1.0.0');
        $result = $instant_article->render('', true)."\n";
        $expected = file_get_contents(__DIR__ . '/global-ia.html');
        $this->assertEqualsHtml($expected, $result);
        $this->assertEquals(0, count($transformer->getWarnings()));
    }
}
