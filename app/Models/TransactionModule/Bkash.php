<?php

namespace App\Models\TransactionModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bkash extends Model
{
    use HasFactory;
    
    protected $appends = ['date'];
    
    public function getDateAttribute()
    {
        return $this->created_at->format('d-m-Y h:i A');
    }
    
    public function transactionType($value): string
    {
        switch ($value) {
            case '10002294':
                $type = 'Payment via API';
                break;
            case '10003126':
                $type = 'Payment via QR';
                break;
            case '10002175':
                $type = 'Payment via USSD';
                break;
            case '10002809':
                $type = 'Redeem Voucher';
                break;
            case '10002264':
                $type = 'M2M Transfer via API';
                break;
            case '10003209':
                $type = 'M2M Transfer via QR';
                break;
            case '10002177':
                $type = 'M2M Transfer via USSD';
                break;
            case '10003476':
                $type = 'Payment via Bank';
                break;
            case '10003237':
                $type = 'B2B Collection Wallet to Merchant Plus (BC2M)';
                break;
            default:
                $type = 'Other';
        }
        
        return $type;
    }
    
    
}
