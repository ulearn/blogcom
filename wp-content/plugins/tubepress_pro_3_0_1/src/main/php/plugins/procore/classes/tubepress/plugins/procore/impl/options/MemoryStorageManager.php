<?php
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * Implementation of org_tubepress_options_storage_StorageManager that just keeps everything
 * in memory.
 */
class tubepress_plugins_procore_impl_options_MemoryStorageManager extends tubepress_impl_options_AbstractStorageManager
{
	private $_options = array();
	
	protected function setOption($optionName, $optionValue)
	{
		$this->_options[$optionName] = $optionValue;
	}
	
	protected function create($optionName, $optionValue)
	{
		$this->_options[$optionName] = $optionValue;
	}
	
	public function get($optionName) {

		return isset($this->_options[$optionName]) ? $this->_options[$optionName] : null;
	}

    /**
     * @return array All the option names currently in this storage manager.
     */
    protected function getAllOptionNames()
    {
        return array_keys($this->_options);
    }
}