<?php

namespace App\Soap\Response;

class SendBrandResponse
{
  /**
   * @var string
   */
  protected $doSendBrandResult;

  /**
   * GetConversionAmountResponse constructor.
   *
   * @param string
   */
  public function __construct($doSendBrandResult)
  {
    $this->doSendBrandResult = $doSendBrandResult;
  }

  /**
   * @return string
   */
  public function getdoSendBrandResult()
  {
    return $this->doSendBrandResult;
  }
}