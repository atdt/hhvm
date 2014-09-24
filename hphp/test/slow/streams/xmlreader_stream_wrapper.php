<?php
class DummyXmlStream {
	var $buf = '<?xml version="1.0"?><testCase/>';
    var $pos;

    function stream_open($path, $mode, $options, &$opened_path) {
        $this->pos = 0;
        return true;
    }

    function stream_read($count) {
        $ret = substr($this->buf, $this->pos, $count);
        $this->pos += strlen($ret);
        return $ret;
    }

    function stream_eof() {
        return $this->pos >= strlen($this->buf);
    }

	function url_stat( $path, $flags ) {
		return array(
			'dev'     => 0,
			'ino'     => 0,
			'mode'    => 0100000,
			'nlink'   => 0,
			'uid'     => 0,
			'gid'     => 0,
			'rdev'    => 0,
			'size'    => strlen($this->buf),
			'atime'   => 0,
			'mtime'   => 0,
			'ctime'   => 0,
			'blksize' => 0,
			'blocks'  => 0,
		);
	}
}

stream_wrapper_register('dummy', 'DummyXmlStream');

$reader = new XMLReader;
$reader->open('dummy://test');
var_dump( $reader->read() );
var_dump( $reader->name );
