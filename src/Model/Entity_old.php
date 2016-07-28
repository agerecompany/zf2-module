<?php

namespace Agere\Module\Model;

/**
 * Module
 */
class ModuleOld
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $mnemo;

    /**
     * @var string
     */
    private $hidden;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $files;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $correspondence;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fields;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $permissionSettings;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cart;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cartItem;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $productGroup;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $schedule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $switcher;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->correspondence = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permissionSettings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cart = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cartItem = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productGroup = new \Doctrine\Common\Collections\ArrayCollection();
        $this->schedule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->switcher = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set namespace
     *
     * @param string $namespace
     *
     * @return Module
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set mnemo
     *
     * @param string $mnemo
     *
     * @return Module
     */
    public function setMnemo($mnemo)
    {
        $this->mnemo = $mnemo;

        return $this;
    }

    /**
     * Get mnemo
     *
     * @return string
     */
    public function getMnemo()
    {
        return $this->mnemo;
    }

    /**
     * Set hidden
     *
     * @param string $hidden
     *
     * @return Module
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return string
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Add status
     *
     * @param \Magere\Status\Model\Status $status
     *
     * @return Module
     */
    public function addStatus(\Magere\Status\Model\Status $status)
    {
        $this->status[] = $status;

        return $this;
    }

    /**
     * Remove status
     *
     * @param \Magere\Status\Model\Status $status
     */
    public function removeStatus(\Magere\Status\Model\Status $status)
    {
        $this->status->removeElement($status);
    }

    /**
     * Get status
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add file
     *
     * @param \Magere\Files\Model\Files $file
     *
     * @return Module
     */
    public function addFile(\Magere\Files\Model\Files $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Magere\Files\Model\Files $file
     */
    public function removeFile(\Magere\Files\Model\Files $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add correspondence
     *
     * @param \Magere\Correspondence\Model\Correspondence $correspondence
     *
     * @return Module
     */
    public function addCorrespondence(\Magere\Correspondence\Model\Correspondence $correspondence)
    {
        $this->correspondence[] = $correspondence;

        return $this;
    }

    /**
     * Remove correspondence
     *
     * @param \Magere\Correspondence\Model\Correspondence $correspondence
     */
    public function removeCorrespondence(\Magere\Correspondence\Model\Correspondence $correspondence)
    {
        $this->correspondence->removeElement($correspondence);
    }

    /**
     * Get correspondence
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCorrespondence()
    {
        return $this->correspondence;
    }

    /**
     * Add field
     *
     * @param \Magere\Fields\Model\Fields $field
     *
     * @return Module
     */
    public function addField(\Magere\Fields\Model\Fields $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param \Magere\Fields\Model\Fields $field
     */
    public function removeField(\Magere\Fields\Model\Fields $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Add permissionSetting
     *
     * @param \Magere\Permission\Model\PermissionSettings $permissionSetting
     *
     * @return Module
     */
    public function addPermissionSetting(\Magere\Permission\Model\PermissionSettings $permissionSetting)
    {
        $this->permissionSettings[] = $permissionSetting;

        return $this;
    }

    /**
     * Remove permissionSetting
     *
     * @param \Magere\Permission\Model\PermissionSettings $permissionSetting
     */
    public function removePermissionSetting(\Magere\Permission\Model\PermissionSettings $permissionSetting)
    {
        $this->permissionSettings->removeElement($permissionSetting);
    }

    /**
     * Get permissionSettings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermissionSettings()
    {
        return $this->permissionSettings;
    }

    /**
     * Add contact
     *
     * @param \Magere\Contacts\Model\Contacts $contact
     *
     * @return Module
     */
    public function addContact(\Magere\Contacts\Model\Contacts $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \Magere\Contacts\Model\Contacts $contact
     */
    public function removeContact(\Magere\Contacts\Model\Contacts $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add cart
     *
     * @param \Magere\Cart\Model\Cart $cart
     *
     * @return Module
     */
    public function addCart(\Magere\Cart\Model\Cart $cart)
    {
        $this->cart[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \Magere\Cart\Model\Cart $cart
     */
    public function removeCart(\Magere\Cart\Model\Cart $cart)
    {
        $this->cart->removeElement($cart);
    }

    /**
     * Get cart
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Add cartItem
     *
     * @param \Magere\Cart\Model\CartItem $cartItem
     *
     * @return Module
     */
    public function addCartItem(\Magere\Cart\Model\CartItem $cartItem)
    {
        $this->cartItem[] = $cartItem;

        return $this;
    }

    /**
     * Remove cartItem
     *
     * @param \Magere\Cart\Model\CartItem $cartItem
     */
    public function removeCartItem(\Magere\Cart\Model\CartItem $cartItem)
    {
        $this->cartItem->removeElement($cartItem);
    }

    /**
     * Get cartItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartItem()
    {
        return $this->cartItem;
    }

    /**
     * Add productGroup
     *
     * @param \Magere\ProductGroup\Model\ProductGroup $productGroup
     *
     * @return Module
     */
    public function addProductGroup(\Magere\ProductGroup\Model\ProductGroup $productGroup)
    {
        $this->productGroup[] = $productGroup;

        return $this;
    }

    /**
     * Remove productGroup
     *
     * @param \Magere\ProductGroup\Model\ProductGroup $productGroup
     */
    public function removeProductGroup(\Magere\ProductGroup\Model\ProductGroup $productGroup)
    {
        $this->productGroup->removeElement($productGroup);
    }

    /**
     * Get productGroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductGroup()
    {
        return $this->productGroup;
    }

    /**
     * Add schedule
     *
     * @param \Magere\Schedule\Model\Schedule $schedule
     *
     * @return Module
     */
    public function addSchedule(\Magere\Schedule\Model\Schedule $schedule)
    {
        $this->schedule[] = $schedule;

        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \Magere\Schedule\Model\Schedule $schedule
     */
    public function removeSchedule(\Magere\Schedule\Model\Schedule $schedule)
    {
        $this->schedule->removeElement($schedule);
    }

    /**
     * Get schedule
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Add switcher
     *
     * @param \Magere\Switcher\Model\Switcher $switcher
     *
     * @return Module
     */
    public function addSwitcher(\Magere\Switcher\Model\Switcher $switcher)
    {
        $this->switcher[] = $switcher;

        return $this;
    }

    /**
     * Remove switcher
     *
     * @param \Magere\Switcher\Model\Switcher $switcher
     */
    public function removeSwitcher(\Magere\Switcher\Model\Switcher $switcher)
    {
        $this->switcher->removeElement($switcher);
    }

    /**
     * Get switcher
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSwitcher()
    {
        return $this->switcher;
    }
}

