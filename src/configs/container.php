<?php
return [
extas\interfaces\plugins\IPluginRepository::class => extas\components\plugins\PluginRepository::class,
extas\interfaces\extensions\IExtensionRepository::class => extas\components\extensions\ExtensionRepository::class,
extas\interfaces\stages\IStageRepository::class => extas\components\stages\StageRepository::class,
extas\interfaces\packages\IPackageClassRepository::class => extas\components\packages\PackageClassRepository::class,
extas\interfaces\repositories\IRepository::class => extas\components\repositories\Repository::class,
extas\interfaces\repositories\drivers\IDriverRepository::class => extas\components\repositories\drivers\DriverRepository::class,
crawlerRepository::class => extas\components\crawlers\CrawlerRepository::class,
repositoryDescriptionRepository::class => extas\components\repositories\RepositoryDescriptionRepository::class,
commandOptionRepository::class => extas\components\options\CommandOptionRepository::class,
entityRepository::class => extas\components\packages\entities\EntityRepository::class,
pluginRepository::class => extas\components\plugins\PluginRepository::class,
extensionRepository::class => extas\components\extensions\ExtensionRepository::class];
