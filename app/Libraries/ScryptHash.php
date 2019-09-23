<?php
namespace App\Libraries;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Password;
use InvalidArgumentException;

class ScryptHash extends Password implements HasherContract {
	private $cpuDiff = 16384;
	private $memoryDiff = 8;
	private $parallelDiff = 1;
	/**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function make($value, array $options = []) {
    	if(isset($options['cpuDiff'])) {
    		$this->setCpuDiff($options['cpuDiff']);
    	}
    	if(isset($options['memoryDiff'])) {
    		$this->setMemoryDiff($options['memoryDiff']);
    	}
    	if(isset($options['parallelDiff'])) {
    		$this->setParallelDiff($options['parallelDiff']);
    	}
    	return Password::hash($value,false,$this->cpuDiff,$this->memoryDiff,$this->parallelDiff);
    }
    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = []) {
    	if(strlen($hashedValue) === 0) {
    		return false;
    	}
    	return Password::checkHash($value,$hashedValue);
    }
    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = []) {
    	$arr = array('cpuDiff'=>$this->cpuDiff,'memoryDiff'=>$this->memoryDiff,'parallelDiff'=>$this->parallelDiff);
    	$checkarr = array_replace($arr, $options);
		$diffarr = explode('$',$hashedValue);
    	$cpuDiff = (int) $diffarr[0];
    	$memoryDiff = (int) $diffarr[1];
    	$parallelDiff = (int) $diffarr[2];
    	if($cpuDiff !== $checkarr['cpuDiff'] 
    		OR $memoryDiff !== $checkarr['memoryDiff'] 
    		OR $parallelDiff !== $checkarr['parallelDiff']) {
    		return true;
    	}
    	return false;
    }
    public function getCpuDiff() {
    	return $this->cpuDiff;
    }
    public function getMemoryDiff() {
    	return $this->memoryDiff;
    }
    public function getParallelDiff() {
    	return $this->parallelDIff;
    }
    public function setCpuDiff($diff) {
    	if ($diff == 0 || ($diff & ($diff - 1)) != 0) {
            throw new InvalidArgumentException("cpuDiff must be > 0 and a power of 2");
        }
        if ($diff > PHP_INT_MAX / 128 / $this->memoryDiff) {
            throw new InvalidArgumentException("Parameter memoryDiff is too large");
        }
        $this->cpuDiff = $diff;
        return $this;
    }
    public function setMemoryDiff($diff) {
	   	if ($diff > PHP_INT_MAX / 128 / $this->parallelDiff) {
	    	throw new InvalidArgumentException("Parameter memoryDiff is too large");
		}
		$this->memoryDiff = $diff;
		$this->setCpuDiff($this->cpuDiff);
		return $this;
    }
    public function setParallelDiff($diff) {
    	$this->parallelDiff = $diff;
    	$this->setMemoryDiff($this->memoryDiff);
    	return $this;
    }

    /**
     * Get information about the given hashed value.
     *
     * @param string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        // TODO: Implement info() method.
    }
}