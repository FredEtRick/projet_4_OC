<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'session' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionBagInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBagInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBag.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Flash/FlashBagInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Flash/FlashBag.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Session.php';

return $this->services['session'] = new \Symfony\Component\HttpFoundation\Session\Session(${($_ = isset($this->services['session.storage.filesystem']) ? $this->services['session.storage.filesystem'] : $this->load('getSession_Storage_FilesystemService.php')) && false ?: '_'}, new \Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag(), new \Symfony\Component\HttpFoundation\Session\Flash\FlashBag());
