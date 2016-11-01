<?php
abstract class AbstractModelClass{
	// Force Extending class to define this method
	abstract protected function update();
	abstract protected function insert();
	abstract protected function delete();
}
?>