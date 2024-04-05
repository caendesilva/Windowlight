<?php

namespace App\Models\Analytics;

use App\Concerns\AnalyticsDateFormatting;
use Database\Factories\Analytics\CodeGenerationEventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * To get insights on how often code generation is used, we collect anonymous usage statistics.
 *
 * @property int $id
 * @property string $language The programming language of the generated code
 * @property bool $hasMenubar Whether the generated code has the menubar enabled
 * @property bool $hasLineNumbers Whether the generated code has line numbers enabled
 * @property bool $hasMenuButtons Whether the generated code has menu buttons enabled
 * @property bool $hasMenubarText Whether the generated code has a filled in menubar
 * @property string $background The background color of the generated code
 * @property int $lines The number of lines in the generated code
 *
 * @method CodeGenerationEventFactory factory($count = null, $state = [])
 */
class CodeGenerationEvent extends Model
{
    use HasFactory;
    use AnalyticsDateFormatting;

    public const UPDATED_AT = null;

    protected $fillable = [
        'language',
        'hasMenubar',
        'hasLineNumbers',
        'hasMenuButtons',
        'hasMenubarText',
        'background',
        'lines',
    ];
}
