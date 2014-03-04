<?php
/*************************************************************
 * Created on  5 may 2011
 * Updated on  5 may 2011
 *
 * Page with tabs template
 *
 * Created by Andreas Sehr
**************************************************************/

/**
 * @author andreas
 */
abstract class page_template {
    protected $m_menu;
    protected $m_default_page;
    protected $m_class_name;

    function menu() {
        return $this->m_menu;
    }

    function default_page() {
        return $this->m_default_page;
    }

    function get_tab($id) {
        return call_user_func(array($this->m_class_name,$id));;
    }
}
?>
