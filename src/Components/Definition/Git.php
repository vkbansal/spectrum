<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Git diff definition
 * @package VKBansal\Prism\Definition\Git
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Git extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'git';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            /*
             * A simple one line comment like in a git status command
             * For instance:
             * $ git status
             * # On branch infinite-scroll
             * # Your branch and 'origin/sharedBranches/frontendTeam/infinite-scroll' have diverged,
             * # and have 1 and 2 different commits each, respectively.
             * nothing to commit (working directory clean)
             */
            'comment'=> "/^#.*$/m",

            /*
             * a string (double and simple quote)
             */
            'string'=> "/(\"|')(\\\\?.)*?\g{1}/m",

            /*
             * a git command. It starts with a random prompt finishing by a $, then "git" then some other parameters
             * For instance:
             * $ git add file.txt
             */
            'command'=> [
                "pattern" => "/^.*\\\$ git .*$/m",
                "inside" => [
                    /*
                     * A git command can contain a parameter starting by a single or a double dash followed by a string
                     * For instance:
                     * $ git diff --cached
                     * $ git log -p
                     */
                    'parameter' => "/\s(--|-)\w+/m"
                ]
            ],

            /*
             * Coordinates displayed in a git diff command
             * For instance:
             * $ git diff
             * diff --git file.txt file.txt
             * index 6214953..1d54a52 100644
             * --- file.txt
             * +++ file.txt
             * @@ -1 +1,2 @@
             * -Here's my tetx file
             * +Here's my text file
             * +And this is the second line
             */
            'coord'=> "/^@@.*@@$/m",

            /*
             * Regexp to match the changed lines in a git diff output. Check the example above.
             */
            'deleted'=> "/^-(?!-).+$/m",
            'inserted'=> "/^\+(?!\+).+$/m",

            /*
             * Match a "commit [SHA1]" line in a git log output.
             * For instance:
             * $ git log
             * commit a11a14ef7e26f2ca62d4b35eac455ce636d0dc09
             * Author: lgiraudel
             * Date:   Mon Feb 17 11:18:34 2014 +0100
             *
             *     Add of a new line
             */
            'commit_sha1'=> "/^commit \w{40}$/m"
        ];
    }
}
