<?php

namespace ManaPHP;

/**
 * Class ManaPHP\Exception
 *
 * @package exception
 */
class Exception extends \Exception
{
    /**
     * @var array
     */
    protected $_bind = [];

    /**
     * @var array
     */
    protected $_json;

    /**
     * Exception constructor.
     *
     * @param string|array $message
     * @param int          $code
     * @param \Exception   $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        if (is_array($message)) {
            if (substr_count($message[0], '%') + 1 >= ($count = count($message)) && isset($message[$count - 1])) {
                /** @noinspection ArgumentUnpackingCanBeUsedInspection */
                $message = call_user_func_array('sprintf', $message);
            } else {
                $this->_bind = $message;
                $message = $message[0];
                unset($this->_bind[0]);

                if (!isset($this->_bind['last_error_message'])) {
                    $this->_bind['last_error_message'] = error_get_last()['message'];
                }

                $tr = [];
                /** @noinspection ForeachSourceInspection */
                foreach ($this->_bind as $k => $v) {
                    $tr[':' . $k] = $v;
                }

                $message = strtr($message, $tr);
            }
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return 500;
    }

    /**
     * @param array|string|int $data
     *
     * @return static
     */
    public function setJson($data)
    {
        if (is_array($data)) {
            $this->_json = $data;
        } elseif (is_string($data)) {
            $this->_json = ['code' => 1, 'message' => $data];
        } elseif (is_int($data)) {
            $this->_json = ['code' => $data, 'message' => $this->getMessage()];
        } else {
            $this->_json = $data;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getJson()
    {
        $code = $this->getStatusCode();
        return $this->_json ?: ['code' => $code === 200 ? -1 : $code, 'message' => $this->getMessage()];
    }

    /**
     * @return array
     */
    public function getBind()
    {
        return $this->_bind;
    }
}
