<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * PowerShell definition
 * @package VKBansal\Spectrum\Definition\PowerShell
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class PowerShell extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'powershell';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => [
                [
                    'pattern' => "/(^|[^`])<#[\w\W]*?#>/",
                    'lookbehind' => true
                ],
                [
                    'pattern' => "/(^|[^`])#.*?(\\r?\\n|$)/",
                    'lookbehind' => true
                ]
            ],
            'string' => [
                'pattern' => "/(\"|')(`?[\w\W])*?\g{1}/m",
                'inside' => []
            ],
            // Matches name spaces as well as casts, attribute decorators. Force starting with letter to avoid matching array indices
            'namespace' => "/\[[a-z][\w\W]*?\]/i",
            'boolean' => "/\\$(true|false)\b/i",
            'variable' => "/\\$\w+\b/i",
            // per http://technet.microsoft.com/en-us/library/hh847744.aspx
            'keyword' => "/\b(Begin|Break|Catch|Class|Continue|Data|Define|Do|DynamicParam|Else|ElseIf|End|Exit|Filter|Finally|For|ForEach|From|Function|If|In|InlineScript|Parallel|Param|Process|Return|Sequence|Switch|Throw|Trap|Try|Until|Using|Var|While|Workflow)\b/i",
            // Cmdlets and aliases. Aliases should come last, otherwise "write" gets preferred over "write-host" for example
            // Get-Command | ?{ $_.ModuleName -match "Microsoft.PowerShell.(Util|Core|Management)" }
            // Get-Alias | ?{ $_.ReferencedCommand.Module.Name -match "Microsoft.PowerShell.(Util|Core|Management)" }
            'function' => "/\b(Add-(Computer|Content|History|Member|PSSnapin|Type)|Checkpoint-(Computer|Content|EventLog|History|Item|ItemProperty|Variable)|Compare-(Object)|Complete-(Transaction)|Connect-(PSSession)|ConvertFrom-(Csv|Json|StringData)|Convert-(Path)|ConvertTo-(Csv|Html|Json|Xml)|Copy-(Item|ItemProperty)|Debug-(Process)|Disable-(ComputerRestore|PSBreakpoint|PSRemoting|PSSessionConfiguration)|Disconnect-(PSSession)|Enable-(ComputerRestore|PSBreakpoint|PSRemoting|PSSessionConfiguration)|Enter-(PSSession)|Exit-(PSSession)|Export-(Alias|Clixml|Console|Csv|FormatData|ModuleMember|PSSession)|ForEach-(Object)|Format-(Custom|List|Table|Wide)|Get-(Alias|ChildItem|Command|ComputerRestorePoint|Content|ControlPanelItem|Culture|Date|Event|EventLog|EventSubscriber|FormatData|Help|History|Host|HotFix|Item|ItemProperty|Job|Location|Member|Module|Process|PSBreakpoint|PSCallStack|PSDrive|PSProvider|PSSession|PSSessionConfiguration|PSSnapin|Random|Service|TraceSource|Transaction|TypeData|UICulture|Unique|Variable|WmiObject)|Group-(Object)|Import-(Alias|Clixml|Csv|LocalizedData|Module|PSSession)|Invoke-(Command|Expression|History|Item|RestMethod|WebRequest|WmiMethod)|Join-(Path)|Limit-(EventLog)|Measure-(Command)|Measure-(Object)|Move-(Item|ItemProperty)|New-(Alias|Event|EventLog|Item|ItemProperty|Module|ModuleManifest|Object|PSDrive|PSSession|PSSessionConfigurationFile|PSSessionOption|PSTransportOption|Service|TimeSpan|Variable|WebServiceProxy)|Out-(Default|File|GridView|Host|Null|Printer|String)|Pop-(Location)|Push-(Location)|Read-(Host)|Receive-(Job)|Receive-(PSSession)|Register-(EngineEvent|ObjectEvent|PSSessionConfiguration|WmiEvent)|Remove-(Computer|Event|EventLog|Item|ItemProperty|Job|Module|PSBreakpoint|PSDrive|PSSession|PSSnapin|TypeData|Variable|WmiObject)|Rename-(Computer|Item|ItemProperty)|Reset-(ComputerMachinePassword)|Resolve-(Path)|Restart-(Computer|Service)|Restore-(Computer)|Resume-(Job|Service)|Save-(Help)|Select-(Object|String|Xml)|Send-(MailMessage)|Set-(Alias|Content|Date|Item|ItemProperty|Location|PSBreakpoint|PSDebug|PSSessionConfiguration|Service|StrictMode|TraceSource|Variable|WmiInstance)|Show-(Command|ControlPanelItem|EventLog)|Sort-(Object)|Split-(Path)|Start-(Job|Process|Service|Sleep|Transaction)|Stop-(Computer|Job|Process|Service)|Suspend-(Job|Service)|Tee-(Object)|Test-(ComputerSecureChannel|Connection|ModuleManifest|Path|PSSessionConfigurationFile)|Trace-(Command)|Unblock-(File)|Undo-(Transaction)|Unregister-(Event|PSSessionConfiguration)|Update-(FormatData)|Update-(Help|List|TypeData)|Use-(Transaction)|Wait-(Event|Job|Process)|Where-(Object)|Write-(Debug|Error|EventLog|Host|Output|Progress|Verbose|Warning)|ac|cat|cd|chdir|clc|cli|clp|clv|compare|copy|cp|cpi|cpp|cvpa|dbp|del|diff|dir|ebp|echo|epal|epcsv|epsn|erase|fc|fl|ft|fw|gal|gbp|gc|gci|gcs|gdr|gi|gl|gm|gp|gps|group|gsv|gu|gv|gwmi|iex|ii|ipal|ipcsv|ipsn|irm|iwmi|iwr|kill|lp|ls|measure|mi|mount|move|mp|mv|nal|ndr|ni|nv|ogv|popd|ps|pushd|pwd|rbp|rd|rdr|ren|ri|rm|rmdir|rni|rnp|rp|rv|rvpa|rwmi|sal|saps|sasv|sbp|sc|select|set|shcm|si|sl|sleep|sls|sort|sp|spps|spsv|start|sv|swmi|tee|trcm|type|write)\b/i",
            'operator' => [
                'pattern' => "/(\W)-(and|x?or|not|eq|ne|gt|ge|lt|le|Like|(Not)?(Like|Match|Contains|In)|Replace)\b/i",
                'lookbehind' => true
            ],
            'punctuation' => "/[|{}[\];(),.]/"
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $inside =& $this->getDefinition('powershell.string.inside');
        $inside['boolean'] = $this->getDefinition('powershell.boolean');
        $inside['variable'] = $this->getDefinition('powershell.variable');
    }
}
