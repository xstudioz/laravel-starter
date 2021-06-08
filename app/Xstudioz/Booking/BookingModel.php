<?php


namespace App\Xstudioz\Booking;


use App\Models\Coupon;

class BookingModel
{
  public ?HotelItem $hotelItem = null;
  public ?CabItem $cabItem = null;
  public ?Coupon $coupon = null;
  public $combo = false;

  //
  private float $basePrice = 0;
  private float $discount = 0;
  //
  private float $tax = 0;
  private float $finalPrice = 0;
  private float $amountAfterDiscount = 0;

  /**
   * @return float|int
   */
  public function getBasePrice()
  {
    return $this->basePrice;
  }

  /**
   * @return float|int
   */
  public function getDiscount()
  {
    return $this->discount;
  }

  /**
   * @return float|int
   */
  public function getTax()
  {
    return $this->tax;
  }

  /**
   * @return float|int
   */
  public function getFinalPrice()
  {
    return $this->finalPrice;
  }

  /**
   * @return float|int
   */
  public function getAmountAfterDiscount()
  {
    return $this->amountAfterDiscount;
  }


  /**
   * @param HotelItem|null $hotelItem
   */
  public function setHotelItem(?HotelItem $hotelItem): void
  {
    $this->hotelItem = $hotelItem;
    BookingFromSession::save($this);
  }

  /**
   * @param CabItem $cabItem
   */
  public function setCabItem(CabItem $cabItem): void
  {
    $this->cabItem = $cabItem;
    BookingFromSession::save($this);

  }


  public function setCoupon(?Coupon $coupon): BookingModel
  {
    if ($coupon == null) {
      $this->coupon = null;

    } else {
      $this->getPrice();
      $this->coupon = $coupon;

      if ($coupon->type == 'AMOUNT') {
        $this->discount = $coupon->value;
      } else {
        $this->discount = round($this->basePrice * $coupon->value / 100, 2);
      }
    }
    return $this;
  }


  function applyCoupon(): BookingModel
  {
    $coupon = $this->coupon;
    if (empty($coupon)) {
      $this->discount = 0;
      return $this;
    }
    if ($coupon->type == 'AMOUNT') {
      $this->discount = $coupon->value;
    } else {
      $this->getPrice();
      $this->discount = round($this->basePrice * $coupon->value / 100, 2);
    }
    return $this;
  }

  public function getPrice(): BookingModel
  {
    $amount = 0;
    if ($this->hotelItem) {
      $amount += $this->hotelItem->getPrice();
    }
    if (isset($this->cabItem))
      $amount += $this->cabItem->getPrice();

    $this->basePrice = $amount;
    return $this;

  }


  public function finalizeCalculations(): array
  {
    $this->getPrice()->applyCoupon();
    $amountAfterDiscount = $this->basePrice - $this->discount;
    $amountAfterDiscount = $this->amountAfterDiscount = $amountAfterDiscount > 0 ? $amountAfterDiscount : 0;
    $tax = $this->tax = TaxCalculator::calculate($amountAfterDiscount, \MyAppSettings::taxRate());
    $this->finalPrice = $amountAfterDiscount + $tax;
    return [
      'basePrice' => $this->basePrice,
      'discount' => $this->discount,
      'amountAfterDiscount' => $amountAfterDiscount,
      'tax' => $tax,
      'finalPrice' => $this->finalPrice
    ];
  }

  /**
   * @return bool
   */
  public function isCombo(): bool
  {
    return $this->combo;
  }

  /**
   * @param bool $combo
   */
  public function setCombo(bool $combo): void
  {
    $this->combo = $combo;
    BookingFromSession::save($this);

  }


}
