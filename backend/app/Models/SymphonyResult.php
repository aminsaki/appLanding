<?php
// app/Models/SymphonyResult.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymphonyResult extends Model
{
    use HasFactory;

    protected $table="music_results";

    protected $fillable = [
        'uid', 'cello_score', 'harp_score', 'piano_score', 'result'
    ];
}
