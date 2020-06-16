<?php

namespace srag\CommentsUI\UI;

use srag\CommentsUI\Ctrl\CtrlInterface;

/**
 * Interface UIInterface
 *
 * @package srag\CommentsUI\UI
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface UIInterface
{

    const LANG_MODULE_COMMENTSUI = "commentsui";


    /**
     * @return string
     */
    public function render() : string;


    /**
     * @param CtrlInterface $ctrl_class
     *
     * @return self
     */
    public function withCtrlClass(CtrlInterface $ctrl_class) : self;


    /**
     * @param string $id
     *
     * @return self
     */
    public function withId(string $id) : self;
}
