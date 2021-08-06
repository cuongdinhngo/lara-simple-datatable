<?php

if (!function_exists('simple_datatable_view')) {
	/**
	 * Get simple table view
	 * 
	 * @return array
	 */
	function simple_table_view(string $view)
	{
        $view = config("simple-datatable.views.{$view}");
        if (is_null($view) || false === isset($view['items']) || empty($view['items'])) {
            throw new \Exception('Simple Datatable View is not found');
        }
        $view['makeup'] = $view['makeup'] ?? config("simple-datatable.default_table_makeup");
        return $view;
	}
}