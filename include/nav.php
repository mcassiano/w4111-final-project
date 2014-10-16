<?php

$website_url = 'http://localdev.com:8888/';

$nav = array(
  'home' => array('public' => true,
                  'logged' => false,
                  'name' => 'Home',
                  'url' => 'register.php',
                  'title' => 'Homepage'),

  'reg' => array('public' => true,
                  'logged' => false,
                  'name' => 'Register',
                  'url' => 'register.php',
                  'title' => 'Sign up for GameGifter'),

  'about' => array('public' => true,
                  'logged' => false,
                  'name' => 'About',
                  'url' => 'about.php',
                  'title' => 'Get to know GameGifter'),

  'cpassword' => array('public' => false,
                  'logged' => false,
                  'name' => 'Create a password',
                  'url' => 'create_password.php',
                  'title' => 'Create a password'),

  'dashboard' => array('public' => false,
                  'logged' => true,
                  'name' => 'Dashboard',
                  'url' => 'register.php',
                  'title' => 'Dashboard'),

  'search' => array('public' => false,
                  'logged' => false,
                  'name' => 'Search results',
                  'url' => 'search.php',
                  'title' => 'Search results'),

  'platforms' => array('public' => false,
                  'logged' => false,
                  'name' => 'Platforms',
                  'url' => 'platforms.php',
                  'title' => 'Platforms'),
);

$sidebar =  array(
  'basic' => array(
    'my_account' => array(
      'url' => 'register.php',
      'title' => 'My account',
      'icon' => 'glyphicon glyphicon-user'
      ),
    'friends' => array(
      'url' => 'friends.php',
      'title' => 'Friends',
      'icon' => 'glyphicon glyphicon-plus-sign'
      ),
    'games' => array(
      'url' => 'games.php',
      'title' => 'Library',
      'icon' => 'glyphicon glyphicon-screenshot'
      ),
    'platforms' => array(
      'url' => 'platforms.php',
      'title' => 'Platforms',
      'icon' => 'glyphicon glyphicon-hdd'
      ),
    ),
  'market' => array(
    'wishlist' => array(
      'url' => 'wishlist.php',
      'title' => 'Wishlist',
      'icon' => 'glyphicon glyphicon-gift'
      ),
    //'badges' => array(
    //  'url' => 'badges.php',
    //  'title' => 'Badges',
    //  'icon' => 'glyphicon glyphicon-star-empty'
    //  ),
    //'store' => array(
    //  'url' => 'store.php',
    //  'title' => 'Store',
    //  'icon' => 'glyphicon glyphicon-shopping-cart'
    //  ),
    ),
  'meta' => array(
    'logout' => array(
      'url' => 'register.php?logout=true',
      'title' => 'Logout',
      'icon' => 'glyphicon glyphicon-off'
      ),
  )
)

?>
