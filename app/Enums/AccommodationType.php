<?php

namespace App\Enums;

enum AccommodationType: string
{
    case Hotel = 'hotel';
    case Guesthouse = 'guesthouse';
    case Hostel = 'hostel';
    case Apartment = 'apartment';
    case BedAndBreakfast = 'bed and breakfast';
    case Other = 'other';
}
