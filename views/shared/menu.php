<?php	
	
foreach ($viewModel->menuItems as $menuSection) {
	echo '<ul class="nav nav-sidebar">';
	if(array_key_exists('link', $menuSection)){
		$active = (strtolower($viewModel->currentMenuItem) == strtolower($menuSection['linkId'])) ? 'current' : '';
		echo "<li><a class='$active' href='" . $menuSection['link'] . "'>{$menuSection['linkText']}</a></li>";	
	}
	
	if (array_key_exists('submenuItems', $menuSection) && is_array($menuSection['submenuItems'])){
		foreach ($menuSection['submenuItems'] as $subMenuItem) {
			if(array_key_exists('link', $subMenuItem)){
				$active = (strtolower($viewModel->currentMenuItem) == strtolower($subMenuItem['linkId'])) ? 'current' : '';
				echo "<li class='subitem'><a class='$active' href='" . $subMenuItem['link'] . "'>{$subMenuItem['linkText']}</a></li>";	
			}
		}
	}
	echo '</ul>';
}		
?>