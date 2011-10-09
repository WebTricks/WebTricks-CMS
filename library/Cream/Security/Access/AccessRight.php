<?php

class Cream_Security_Access_AccessRight
{
	/**
	 * Access right if new items can be created under the item.
	 * 
	 * @var string
	 */
	const itemCreate = 'create';

	/**
	 * Access right if the item can be deleted.
	 * 
	 * @var string
	 */
	const itemDelete = 'delete';

	/**
	 * Access right if the item can be read.
	 * 
	 * @var string
	 */
	const itemRead = 'read';
	
	/**
	 * Access right if the item can be renamed.
	 * 
	 * @var string
	 */
	const itemRename = 'rename';

	/**
	 * Access right if the item can be saved.
	 * 
	 * @var string
	 */
	const itemWrite = 'write';

	/**
	 * Access right if the item can be administert.
	 * 
	 * @var string
	 */
	const itemAdmin = 'admin';
}