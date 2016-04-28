<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/25/2016
 * Time:    3:07 PM
 **/

namespace Application\Models;


/**
 * Class A_Person
 * @package Application\Models
 */
class A_Person extends A_DomainObject
{
    private $photo;
    private $title;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $email;
    private $phone;
    private $password;
    private $address1;
    private $address2;
    private $city;
    private $zip_code;
    private $state;
    private $country;
    private $biography;

    /**
     * Person constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        if(! is_object($this->photo))
        {
            $this->photo = Upload::getMapper("Upload")->find($this->photo);
        }
        return $this->photo;
    }

    /**
     * @param mixed $photo
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return A_Person
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * @param mixed $middle_name
     * @return User
     */
    public function setMiddleName($middle_name)
    {
        $this->middle_name = $middle_name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        $this->markDirty();
        return $this;
    }

    public function getNames()
    {
        return implode(" ", array($this->title, $this->first_name, $this->middle_name, $this->last_name));
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = strtolower($email);
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     * @return User
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     * @return User
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param mixed $zip_code
     * @return User
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     * @return A_Person
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
        $this->markDirty();
        return $this;
    }
}