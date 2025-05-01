<?php

require_once "vendor/autoload.php";
require_once "helpers/Run.php";
require_once "bootstrap.php";

use helpers\Run;
use Models\Modification;
use Models\Snippet;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

$snippets = scandir("snippets");

$parser = (new ParserFactory())->createForNewestSupportedVersion();

foreach ($snippets as $snippet_name) {
    $full_path = "snippets/{$snippet_name}";

    if (!is_file($full_path)) { continue; }

    $code = file_get_contents($full_path);

    // run snippet before modification
    $pre_modification_output = Run::runSnippet($full_path);

    // add snippet to db
    $snippet = Snippet::create([
        'path' => $full_path,
        'output' => $pre_modification_output,
    ]);

    echo "Running snippet {$snippet->id} ---------------- \n\n";

    try {
        $ast = $parser->parse($code);

        $traverser = new NodeTraverser();
//        $traverser->addVisitor(new class extends NodeVisitorAbstract {
//            public function enterNode(Node $node) {
//                echo $node;
//                if ($node instanceof Node\Stmt\Echo_) {
//                    // Clean out the function body
//                    $node->exprs = [];
//                }
//            }
//        });

        $ast = $traverser->traverse($ast);
        $prettyPrinter = new Standard;
        $modified_file = $prettyPrinter->prettyPrintFile($ast);

        $modified_path = "snippets/modifications/{$snippet_name}";
        file_put_contents($modified_path, $modified_file);

        // run modified file
        $post_modification_output = Run::runSnippet($modified_path);
        $passed = $pre_modification_output === $post_modification_output;

        // add modification to db
        $modification = Modification::create([
            'snippet_id' => $snippet->id,
            'path' => $full_path,
            'output' => $post_modification_output,
            'passed' => $passed,
        ]);

        $passed_text = $passed ? '32mpassed' : '31mfailed';

        echo "Modification {$modification->id} \033[01;{$passed_text}";

        // reset colour
        echo "\033[0m";

        // save the result in sqlite
    } catch (Error $e) {
        echo "Error Parsing snippet {$snippet_name}\n";
        echo $e->getMessage();
        return;
    }

    echo "\n";
}
