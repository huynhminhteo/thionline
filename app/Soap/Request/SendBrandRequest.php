<?php

namespace App\Soap\Request;

class SendBrandRequest
{

  protected $UserID;

  protected $Message;

  protected $Brand;

  protected $TypeURL;

  protected $RealTime;

  protected $Username;

  protected $Password;

  /**
   * GetConversionTypeURL constructor.
   *
   * @param string $UserID
   * @param string $Message
   * @param string $Brand
   * @param string $TypeURL
   */
  public function __construct($UserID, $Message, $Brand, $TypeURL, $RealTime, $Username, $Password)
  {
    $this->UserID = $UserID;
    $this->Message = $Message;
    $this->Brand = $Brand;
    $this->TypeURL = $TypeURL;
    $this->RealTime = $RealTime;
    $this->Username = $Username;
    $this->Password = $Password;
  }

  /**
   * @return string
   */
  public function getUserID()
  {
    return $this->UserID;
  }

  /**
   * @return string
   */
  public function getMessage()
  {
    return $this->Message;
  }

  /**
   * @return string
   */
  public function getBrand()
  {
    return $this->Brand;
  }

  /**
   * @return string
   */
  public function getTypeURL()
  {
    return $this->TypeURL;
  }

  public function getRealTime()
  {
    return $this->RealTime;
  }

  public function getUsername()
  {
    return $this->Username;
  }

  public function getPassword()
  {
    return $this->Password;
  }
}