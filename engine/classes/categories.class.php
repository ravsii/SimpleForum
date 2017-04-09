<?php

class Categories {
    public static function getCategoriesAsArray() {
        global $db;

        $result = array();

        $cat = $db->query("SELECT `id`, `name` FROM `categories` WHERE `parent` IS NULL;");
        while ($row = $cat->fetch_assoc()) {
            $subcat = $db->query("SELECT `id`, `name` FROM `categories` WHERE `parent` = '" . $row["id"] . "';");
            while ($subrow = $subcat->fetch_assoc()) {
                $row["subs"][] = $subrow;
            }
            $result[] = $row;
        }

        return $result;
    }

    public static function getCounterViewCategories($id){
        global $db;

        $view_categories = $db->query("SELECT `categories_counter_view` FROM `categories` WHERE `id` = '{$id}';")->fetch_assoc();

        $view_topic['counter_view'] = $view_categories['counter_view'] + 1;

        $db->query("UPDATE topics  SET counter_view = '{$view_topic['counter_view']}' WHERE id = '{$id}';");

        return  $view_topic['counter_view'];

    }
    public static function getCategoriesAsHtml() {
        global $template;

        $_html = "";
        foreach (Categories::getCategoriesAsArray() as $cat) {
            $cat_html = $template->getTextFromFile("/categories/category.tpl");

            $cat_html = str_replace("{cat_id}", $cat["id"], $cat_html);
            $cat_html = str_replace("{cat_name}", $cat["name"], $cat_html);

            $sub_html = "";
            foreach ($cat["subs"] as $sub) {
                $sub_html_t = $template->getTextFromFile("/categories/subcategory.tpl");
                $sub_html_t = str_replace("{subcat_id}", $sub["id"], $sub_html_t);
                $sub_html_t = str_replace("{subcat_name}", $sub["name"], $sub_html_t);
                $sub_html .= $sub_html_t;
            }

            $cat_html = str_replace("{sub_categories}", $sub_html, $cat_html);
            $_html .= $cat_html;
        }

        return $_html;
    }
}