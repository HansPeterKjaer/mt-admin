<?php	
	
foreach ($viewModel->menuItems as $menuSection) {
	echo '<ul class="nav nav-sidebar">';
	if(array_key_exists('link', $menuSection)){
		$active = (strtolower($viewModel->currentMenuItem) == strtolower($menuSection['link'])) ? 'active' : '';
		echo "<li class='$active'><a href='" . URLHelper::getURL($menuSection['link']) . "'>{$menuSection['linkText']}</a></li>";	
	}
	
	if (array_key_exists('submenuItems', $menuSection) && is_array($menuSection['submenuItems'])){
		foreach ($menuSection['submenuItems'] as $subMenuItem) {
			if(array_key_exists('link', $subMenuItem)){
				$active = (strtolower($viewModel->currentMenuItem) == strtolower($subMenuItem['link'])) ? 'active' : '';
				echo "<li class='$active subitem'><a href='" . URLHelper::getURL($subMenuItem['link']) . "'>{$subMenuItem['linkText']}</a></li>";	
			}
		}
	}
	echo '</ul>';
}		
?>