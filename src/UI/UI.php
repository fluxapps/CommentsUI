<?php

namespace srag\CommentsUI\UI;

use ilTemplate;
use srag\CommentsUI\Ctrl\CtrlInterface;
use srag\CommentsUI\Utils\CommentsUITrait;
use srag\CustomInputGUIs\Template\Template;
use srag\DIC\DICTrait;

/**
 * Class UI
 *
 * @package srag\CommentsUI\UI
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class UI implements UIInterface
{

    use DICTrait;
    use CommentsUITrait;
    /**
     * @var bool
     */
    protected static $init = false;
    /**
     * @var string
     */
    protected $id = "";
    /**
     * @var CtrlInterface
     */
    protected $ctrl_class;


    /**
     * UI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function withId(string $id) : UIInterface
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function withCtrlClass(CtrlInterface $ctrl_class) : UIInterface
    {
        $this->ctrl_class = $ctrl_class;

        return $this;
    }


    /**
     * @param ilTemplate $tpl
     */
    private function initJs(ilTemplate $tpl) : void
    {
        if (self::$init === false) {
            self::$init = true;

            $dir = __DIR__;
            $dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1);

            self::dic()->ui()->mainTemplate()->addJavaScript($dir . "/../../node_modules/jquery-comments/js/jquery-comments.js");
            self::dic()->ui()->mainTemplate()->addCss($dir . "/../../node_modules/jquery-comments/css/jquery-comments.css");

            self::dic()->ui()->mainTemplate()->addJavaScript($dir . "/../../js/commentsui.min.js");
            self::dic()->ui()->mainTemplate()->addCss($dir . "/../../css/commentsui.css");

            $tpl->setCurrentBlock("init");

            $tpl->setVariable("LANGUAGES", json_encode($this->getLanguageStrings()));

            $tpl->setVariable("PROFILE_IMAGE_URL", json_encode(self::dic()->user()->getPersonalPicturePath("big")));
        }
    }


    /**
     * @inheritDoc
     */
    public function render() : string
    {
        $tpl = new Template(__DIR__ . "/../../templates/commentsui.html", false, false);

        $tpl->setVariableEscaped("ID", $this->id);

        $tpl->setVariable("READONLY", json_encode($this->ctrl_class->getIsReadOnly()));

        $tpl->setVariable("ASYNC_BASE_URL", json_encode($this->ctrl_class->getAsyncBaseUrl()));

        $this->initJs($tpl);

        return self::output()->getHTML($tpl);
    }


    /**
     * @return array
     */
    protected function getLanguageStrings() : array
    {
        return array_map(function (string $key) : string {
            return self::comments()->getPlugin()->translate($key, self::LANG_MODULE_COMMENTSUI);
        }, [
            "deleteText"              => "delete",
            "editText"                => "edit",
            "editedText"              => "edited",
            "noCommentsText"          => "no_comments",
            "newestText"              => "newest",
            "oldestText"              => "oldest",
            "saveText"                => "save",
            "sendText"                => "save",
            "shareText"               => "share_comment_for_user",
            "textareaPlaceholderText" => "comment",
            //"hideRepliesText" => "Hide replies",
            //"popularText" => "Popular",
            //"replyText" => "Reply",
            //"viewAllRepliesText" => "View all __replyCount__ replies",
            //"youText" => "You",
        ]);
    }
}
