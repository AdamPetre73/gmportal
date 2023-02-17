<?php
/**
 * Dasboard - Implements a simple Administration Dashboard.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Modules\Wiki\Controllers\Admin;

use Core\View;
use Helpers\Url;
use DB;
use Input;
use Redirect;

use App\Core\Controller;


class Wiki extends Controller
{
    protected $template = 'AdminLte';
    protected $layout   = 'backend';


    public function __construct()
    {
        parent::__construct();
    }

    // Include the html parser
    // Params: none
    // Returns: none
    public function includeHtmlParser(){
        $path = ROOTDIR . '/app/Templates/AdminLte/Assets/simplehtmldom/';
        $file = 'simple_html_dom.php';
        include_once($path.$file);
    }

    public function index()
    {
        $heroes = $this->heroesForDashboard();

        return $this->getView()
            ->shares('title', __d('wiki', 'Wiki'))
            ->with('heroes', $heroes);
    }

    public function renamePictures(){
        $heroes = DB::table('wiki_heroes')->select('id','icon')->get();
        foreach($heroes as $hero){
            DB::table('wiki_heroes')->where('id',$hero->id)->update(['icon' => str_replace(' ', '', $hero->icon)]);
        }
    }

    public function scrapeHeroesPage(){
        $minUrl = 'https://hon.fandom.com';
        $baseUrl = 'https://hon.fandom.com/wiki/Heroes';
        $this->includeHtmlParser();

        $basePath = ROOTDIR . '/app/Templates/AdminLte/Assets/Heroes/';
        $imagesPath = $basePath . 'Images/Icons/';
        $fileName = 'heroes_page.html';

        $heroes = [];

        // check if we have the page saved
        if(!file_exists($basePath . $fileName)){
            // we don't have the file, so we download it
            $html = @file_get_html($baseUrl);
            if(!empty($html)){
                file_put_contents($basePath . $fileName, $html);
            } else {
                die('We couldn\'t get the page. Try something else.');
            }
        } else {
            // we already have the file, we can start parsing it
            $html = file_get_html($basePath . $fileName);
        }

        $mainDiv = $html->find('div.mw-parser-output', 0);
        $mainDiv = $mainDiv->find('table', 1);
        $mainDiv = $mainDiv->find('table', 0);
        foreach($mainDiv->find('table') as $section){
            foreach($section->find('a') as $link){
                $hero = [
                    'url'   => $minUrl . $link->href,
                    'name'  => $link->title
                ];
                $scrapeHeroes[] = $hero;
            }
        }

        foreach($scrapeHeroes as $hero){
            if(!file_exists($basePath . $hero['name'] . '.html')){
                // we don't have the file, so we download it
                $html = @file_get_html($hero['url']);
                // save the file
                file_put_contents($basePath . $hero['name'] . '.html', $html);
            } else {
                // we already have the hero page, we parse it
                $html = @file_get_html($basePath . $hero['name'] . '.html');
            }

            $heroData = [];
            $heroAbilities = [];
            $name = $html->find('h1', 0)->innertext;
            $name = trim(rtrim($name));
            $mainDiv = $html->find('div.mw-parser-output', 0);
            $table = $mainDiv->find('table', 0);
            $heroIconUrl = $table->find('a', 0)->href;
            // download the Hero Icon
            $extension = explode('.', $heroIconUrl);
            $extension = '.' . $extension[count($extension) - 1];
            $extension = explode('/', $extension);
            $extension = $extension[0];
            $heroIcon = explode($extension, $heroIconUrl);
            $heroIcon = $heroIcon[0] . $extension;
            file_put_contents($basePath . 'Images/Icons/' . $name . $extension, file_get_contents($heroIcon));
            $heroIcon = $basePath . 'Images/Icons/' . $name . $extension;
            $faction = $table->find('tr', 2);
            $faction->find('img', 0)->outertext = '';
            $faction = str_replace(' ', '', $faction->find('th', 0)->innertext);
            $attributes = $table->find('tr', 4);
            $attributes =$attributes->find('table', 0);
            $heroAttributes['strength'] = $attributes->find('td', 1)->find('b', 0)->innertext;
            if(stripos($attributes->find('td',1)->style,'color:#f6f700') !== false){
                $mainAttribute = 'Strength';
            }
            $heroAttributes['agility'] = $attributes->find('td', 3)->find('b', 0)->innertext;
            if(stripos($attributes->find('td',3)->style,'color:#f6f700') !== false){
                $mainAttribute = 'Agility';
            }
            $heroAttributes['inteligence'] = $attributes->find('td', 5)->find('b', 0)->innertext;
            if(stripos($attributes->find('td',5)->style,'color:#f6f700') !== false){
                $mainAttribute = 'Intelligence';
            }
            $heroHealth = $table->find('tr', 9);
            $heroHealth = $heroHealth->find('td', 1)->innertext;
            $heroHealth = str_replace(' ', '', $heroHealth);
            $heroMana = $table->find('tr', 10);
            $heroMana = $heroMana->find('td', 1)->innertext;
            $heroMana = str_replace(' ', '', $heroMana);
            $heroDamage = $table->find('tr', 11);
            $heroDamage = $heroDamage->find('td', 1)->innertext;
            $heroDamage = str_replace(' ', '', $heroDamage);
            $heroArmor = $table->find('tr',12);
            $heroArmor = $heroArmor->find('td',1)->innertext;
            $heroArmor = str_replace(' ', '', $heroArmor);
            $stats = $table->find('tr', 14);
            $stats = $stats->find('table', 0);
            $movementSpeed = $stats->find('tr', 0);
            $movementSpeed = str_replace(' ', '', $movementSpeed->find('td',1)->innertext);
            $magicArmor = $stats->find('tr', 1);
            $magicArmor = str_replace(' ', '', $magicArmor->find('td', 1)->innertext);
            $healthRegen = $stats->find('tr', 2);
            $healthRegen = str_replace(' ', '', $healthRegen->find('td', 1)->innertext);
            $range = $stats->find('tr', 3);
            $range = $range->find('td', 1)->innertext;
            preg_match('(\d+)', $range, $rangeValue);
            $rangeValue = $rangeValue[0];
            preg_match('([A-Za-z]+)', $range, $ranged);
            $ranged = $ranged[0];
            $missileSpeed = $stats->find('tr', 4);
            $missileSpeed = str_replace(' ', '', $missileSpeed->find('td', 1)->innertext);
            $baseAttackTime = $stats->find('tr', 5);
            $baseAttackTime = str_replace(' ', '', $baseAttackTime->find('td', 1)->innertext);
            $attackAnimation = $stats->find('tr', 6);
            $attackAnimation = str_replace(' ', '', $attackAnimation->find('td', 1)->innertext);
            $turnRate = $stats->find('tr', 6);
            $turnRate = str_replace(' ', '', $turnRate->find('td', 1)->innertext);

            $lore = $mainDiv->find('table', 3);
            $lore = $lore->find('td', 0)->innertext;

            // Abilities
            // Leave them for now
            // $tables = $mainDiv->find('table');
            // foreach($tables as $k => $table){
            //     if($table->hasClass('wikitable')){
            //         break;
            //     }
            //     if(str_replace(' ', '', $table->style) == 'border:0;padding:0;margin:0;margin-bottom:1em;'){
            //         $abilities[] = $table;
            //     }
            // }
            // foreach($abilities as $k => $abi){
            //     echo $abi;
            //     echo '<hr>';
            // }
            // die();

            $heroData['icon'] = $heroIcon;
            $heroData['faction'] = $faction;
            $heroData['name'] = $name;
            $heroData['strength'] = (int)$heroAttributes['strength'];
            $heroData['agility'] = (int)$heroAttributes['agility'];
            $heroData['inteligence'] = (int)$heroAttributes['inteligence'];
            $heroData['main_attribute'] = $mainAttribute;
            $heroData['health'] = (int)$heroHealth;
            $heroData['mana'] = (int)$heroMana;
            $heroData['damage'] = $heroDamage;
            $heroData['armor'] = (double)$heroArmor;
            $heroData['movement_speed'] = (int)$movementSpeed;
            $heroData['magic_armor'] = (int)$magicArmor;
            $heroData['health_regen'] = (double)$healthRegen;
            $heroData['attack_range'] = (int)$rangeValue;
            $heroData['ranged'] = $ranged;
            $heroData['missile_speed'] = (int)$missileSpeed;
            $heroData['base_attack_time'] = (double)$baseAttackTime;
            $heroData['attack_animation'] = $attackAnimation;
            $heroData['turn_rate'] = (int)$turnRate;
            $heroData['lore'] = $lore;

            // check if the hero already exists
            $existing = DB::table('wiki_heroes')->where('name', $heroData['name'])->first();
            if(!empty($existing)){
                DB::table('wiki_heroes')->where('id',$existing->id)->update($heroData);
            } else {
                DB::table('wiki_heroes')->insert($heroData);
            }
        }

        echo 'Finished';
        die();
    }

    public function heroesForDashboard(){
        $heroes = DB::table('wiki_heroes')->get();
        $sorted = [
            'legion'        => [
                'strength'      => [],
                'agility'       => [],
                'intelligence'  => [],
            ],
            'hellbourne'    => [
                'strength'      => [],
                'agility'       => [],
                'intelligence'  => [],
            ],
        ];


        foreach($heroes as $hero){
            $sorted[strtolower($hero->faction)][strtolower($hero->main_attribute)][] = $hero;
        }

        return View::fetch('Admin/Wiki/heroesForDashboard', [
            'heroes'    => $sorted
        ], 'Wiki');
    }

    public function heroPage($heroId){
        $hero = DB::table('wiki_heroes')->where('id',$heroId)->first();
        if(empty($hero)){
            return Redirect::to('/admin/wiki')->withStatus(__d('The specified hero could not be found.', 'wiki'), 'danger');
        }

        $dir = ROOTDIR . 'assets/images/' . $hero->id . '/';
        $files = array_diff(scandir($dir), array('.', '..', $hero->name . '.html'));

        if(!empty($files)){
            $images = [];
            foreach($files as $file){
                if(stripos($file, 'motd') !== false){
                    // skip
                    continue;
                }
                if(stripos($file, 'ability') !== false){
                    if(stripos($file, 'alt') !== false){
                        // skip
                        continue;
                    } else {
                        $abilities[] = $file;
                    }
                }
                if(stripos($file, 'icon') !== false){
                    $icons[] = $file;
                }
                if(stripos($file, 'store_') !== false){
                    $avatars[] = $file;
                }
            }
            $images['abilities'] = !empty($abilities) ? $abilities : [];
            $images['icons'] = !empty($icons) ? $icons : [];
            $images['avatars'] = !empty($avatars) ? $avatars : [];
            unset($avatars);

            foreach($images['avatars'] as $k => $v){
                if(stripos($v, 'hero') !== false){
                    $avatars[0] = $v;
                } else {
                    $avatars[$k+100] = $v;
                }
            }
            foreach($avatars as $k => $v){
                if($k > 0){
                    $avatars[$k-99] = $v;
                    unset($avatars[$k]);
                }
            }
            $images['avatars'] = $avatars;
        } else {
            die('we don\'t have any images yet.');
        }

        $abilities = DB::table('wiki_heroes_abilities')->where('hero_id', $hero->id)->get();

        return $this->getView()
            ->shares('title', __d('wiki', $hero->name))
            ->with('hero', $hero)
            ->with('images', $images)
            ->with('abilities', $abilities);
    }

    public function getRemainingHeroes(){
        $dir = ROOTDIR . 'assets/images/';
        $heroes = DB::table('wiki_heroes')->select('id')->get();
        foreach($heroes as $hero){
            $heroesIds[] = $hero->id;
        }
        $existing = scandir($dir);

        foreach($existing as $k => $e){
            if($e == '.' || $e == '..'){
                unset($existing[$k]);
                continue;
            }
            if(!is_dir($dir . $e)){
                unset($existing[$k]);
                continue;
            }
        }

        $remaining = array_diff($heroesIds, $existing);

        echo '<pre>';
        print_r($remaining);
        echo '</pre>';
        die();
    }

    public function getHeroesDataFromArchive(){
        $this->includeHtmlParser();
        $baseUrl = 'https://web.archive.org';
        $archiveUrl = 'https://web.archive.org/web/20220629172437/https://www.heroesofnewerth.com/heroes/view/';
        $heroes = DB::table('wiki_heroes')->select('id','name')->get();

        foreach($heroes as $hero){
            // check if we already have the file
            $dir = ROOTDIR . 'app/Templates/AdminLte/Assets/Heroes/Archive/' . $hero->id;
            if(!file_exists($dir)){
                // we don't have the file, we download it
                $html = @file_get_html($archiveUrl . $hero->id);
                // create the directory
                mkdir($dir, 0777, true);
                file_put_contents($dir . '/' . $hero->name . '.html', $html);
            } else {
                // we already have the file, we scrape it
                $html = @file_get_html($dir . '/' . $hero->name . '.html');
            }

            // we have the file, now we process it
            // foreach($html->find('comment') as $k => &$element){
            //     $element->outertext = '';
            // }
            // foreach($html->find('script') as $k => &$element){
            //     $element->outertext = '';
            // }
            // foreach($html->find('noscript') as $k => &$element){
            //     $element->outertext = '';
            // }
            // foreach($html->find('style') as $k => &$element){
            //     $element->outertext = '';
            // }
            // foreach($html->find('.floatClear') as $k => &$element){
            //     $element->outertext = '';
            // }
            // foreach($html->find('.addSpace') as $k => &$element){
            //     $element->outertext = '';
            // }

            // $html->find('#wm-ipp-base', 0)->outertext = '';
            // $html->find('#wm-ipp-print', 0)->outertext = '';
            // $html->find('#fb-root', 0)->outertext = '';
            // $html->find('#loginBar', 0)->outertext = '';
            // $html->find('#mLeaves', 0)->outertext = '';
            // $html->find('.navigation', 0)->outertext = '';
            // $html->find('#footer', 0)->outertext = '';
            // $html->find('#dialog-message', 0)->outertext = '';
            // $html->find('#errorBar', 0)->outertext = '';
            // $html->find('#lightbox_notMedia', 0)->outertext = '';
            //$html->find('.heroWrapper', 0)->outertext = '';

            // $html = $html->find('#mainContent',0);
            //$html = $html->find('.wrapper', 0);

            $data['avatars'] = [];

            $data['name'] = ucwords(strtolower(trim(rtrim(str_ireplace('HERO:','',$html->find('p.title', 0)->innertext)))));
            $icon = $html->find('#header', 0)->find('img#icon', 0)->src;
            $icon = $this->downloadFile($baseUrl.$icon, $dir);
            $data['avatars'][0]['icon'] = $icon;

            // Abilities
            $abilities = [];
            foreach($html->find('.abil') as $k => $ability){
                $icon = $ability->find('.theIcon', 0);
                $icon = $icon->style;
                preg_match_all("(\'[\s\S]+\')", $icon, $matches);
                $icon = str_replace("'", '', $matches[0]);
                $key = $ability->find('.key',0)->innertext;
                $name = $ability->find('.theHeader',0)->find('p.title',0);

                $span = $name->find('span.regular',0)->innertext;
                $span = explode('|', $span);

                $range = $manaCost = null;

                foreach($span as $s){
                    if(stripos($s,'Range:') !== false){
                        $range = str_replace(' ','',str_ireplace('Range:','',$s));
                    }
                    if(stripos($s,'Mana Cost:') !== false){
                        $manaCost = str_replace(' ','',str_ireplace('Mana Cost:','',$s));
                    }
                }
                foreach($name->find('span.regular') as $k => &$span){
                    $span->outertext = '';
                }
                $name = $name->innertext;

                $description = $ability->find('.theText',0);
                
                $desc['simple'] = $description->find('p.simple',0)->plaintext;
                $desc['advanced'] = $description->find('div.advanced',0)->plaintext;

                if(is_array($desc['simple'])){
                    $desc['simple'] = implode('',$desc['simple']);
                }
                if(is_array($desc['advanced'])){
                    $desc['advanced'] = implode('',$desc['advanced']);
                }

                // $desc['simple'] = str_replace('  ','',$desc['simple']);
                // $desc['simple'] = str_replace('	','',$desc['simple']);
                // $desc['simple'] = str_replace('\t','',$desc['simple']);
                // $desc['simple'] = str_replace('\r','',$desc['simple']);
                // $desc['advanced'] = str_replace('  ','',$desc['advanced']);
                // $desc['advanced'] = str_replace('	','',$desc['advanced']);
                // $desc['advanced'] = str_replace('\t','',$desc['advanced']);
                // $desc['advanced'] = str_replace('\r','',$desc['advanced']);

                $thisAbility = [];

                $thisAbility['icon'] = $icon;
                $thisAbility['key'] = $key;
                $thisAbility['name'] = $name;
                $thisAbility['range'] = !empty($range) ? $range : null;
                $thisAbility['mana_cost'] = !empty($manaCost) ? $manaCost : null;
                $thisAbility['description'] = $desc;

                $abilities[] = $thisAbility;
            }

            $data['abilities'] = $abilities;

            // stats
            $bottom = $html->find('#heroBottom',0)->find('.heroLeft',0);

            $simpleStats = $bottom->find('#stats',0);
            $simpleStats = $simpleStats->find('.theText',0);
            $simpleStats = $simpleStats->find('div',0);
            foreach($simpleStats->find('p') as $k => $p){
                $p = explode(':',$p->innertext);
                $stat = str_replace(' ','_',strtolower($p[0]));
                $value = $p[1];
                $stats[$stat] = $value;
            }
            

            $advStats = $bottom->find('#advStats',0);
            $advStats = $advStats->find('.theText',0);
            foreach($advStats->find('p') as $k => $p){
                $p = explode(':',$p->innertext);
                $stat = str_replace(' ','_',strtolower($p[0]));
                $value = $p[1];
                $stats[$stat] = $value;
            }
            $data['stats'] = $stats;

            // lore
            $lore = $html->find('#heroBottom',0)->find('#lore',0)->find('.theText',0);
            $text = '';
            foreach($lore->find('p') as $p){
                $text .= $p->innertext;
            }
            $lore = $text;
            $data['lore'] = $lore;

            // if(empty($data['stats']['strength'])){
            //     echo '<pre>';
            //     print_r($data);
            //     echo '</pre>';
            //     die();
            // }

            DB::table('wiki_heroes')->where('id',$hero->id)->update([
                'icon'                  => $data['avatars'][0]['icon'],
                'strength'              => $data['stats']['strength'],
                'agility'               => $data['stats']['agility'],
                'inteligence'           => $data['stats']['intelligence'],
                'health'                => $data['stats']['health'],
                'mana'                  => $data['stats']['mana'],
                'damage'                => $data['stats']['damage'],
                'armor'                 => $data['stats']['armor'],
                'movement_speed'        => $data['stats']['movement_speed'],
                'attack_range'          => $data['stats']['range'],
                'lore'                  => $data['lore']
            ]);
            
            // echo '<pre>';
            // print_r($data['abilities']);
            // echo '</pre>';
            // die();

            foreach($data['abilities'] as $k => $ability){
                // echo '<pre>';
                // print_r($ability);
                // echo '</pre>';
                // die();

                $existing = DB::table('wiki_heroes_abilities')->where('hero_id',$hero->id)->where('ability_id', $k)->first();
                if(!empty($existing)){
                    // update
                    $icon = explode('/',$ability['icon'][0]);
                    $icon = $icon[count($icon) - 1];
                    DB::table('wiki_heroes_abilities')->where('hero_id',$hero->id)->where('ability_id',$k)->update([
                        'ability_id'    => $k,
                        'hero_id'       => $hero->id,
                        'name'          => $ability['name'],
                        'icon'          => $icon,
                        'ability_key'   => $ability['key'],
                        'ability_range' => !empty($ability['range']) ? $ability['range'] : $existing->ability_range,
                        'mana_cost'     => !empty($ability['mana_cost']) ? $ability['mana_cost'] : $existing->mana_cost,
                        'description'   => $ability['description']['simple'],
                        'description2'  => $ability['description']['advanced'],
                    ]);
                } else {
                    // insert
                    $icon = explode('/',$ability['icon'][0]);
                    $icon = $icon[count($icon) - 1];
                    DB::table('wiki_heroes_abilities')->insert([
                        'ability_id'    => $k,
                        'hero_id'       => $hero->id,
                        'name'          => $ability['name'],
                        'icon'          => $icon,
                        'ability_key'   => $ability['key'],
                        'ability_range' => $ability['range'],
                        'mana_cost'     => $ability['mana_cost'],
                        'description'   => $ability['description']['simple'],
                        'description2'  => $ability['description']['advanced'],
                    ]);
                }
            }
        }

        return Redirect::to('/admin/wiki')->withStatus('Finished Updating!','success');
    }

    public function downloadFile($url, $path, $forced = false){
        $filename = explode('/',$url);
        $filename = $filename[count($filename) - 1];

        if($forced == false){
            // check if we already have the file
            if(file_exists($path . '/' . $filename)){
                // we already have the file
                return $filename;
            }
        }

        $file = @file_get_contents($url);

        if(!$file || $file == false){
            return 'No file';
        }
        if(stripos($file,'Hm.') !== false){
            return 'File not found';
        }

        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }
        file_put_contents($path . '/' . $filename, $file);
        return $filename;
    }

    public function getAllHeroMediaFromArchive(){
        $baseUrl = 'https://web.archive.org';
        $baseHeroUrl = 'https://web.archive.org/web/20220629172437/https://www.heroesofnewerth.com/heroes/view/';
        $baseMediaUrl = 'https://web.archive.org/web/20220629172438im_/https://www.heroesofnewerth.com/images/heroes/';
        $heroDir = ROOTDIR . 'app/Templates/AdminLte/Assets/Heroes/Archive/';

        $filesToGet = [
            'avatars'   => [
                'store_hero.png',
                'store_alt.png',
                'store_alt[x].png',
            ], 
            'icons' => [
                'icon_128.jpg',
                'icon_128_alt.jpg',
                'icon_128_alt[x].jpg',
            ],
            'abilities' => [
                'ability[x]_128.jpg',
            ]
        ];

        $heroes = DB::table('wiki_heroes')->select('id','name')->get();

        foreach($heroes as $hero){
            $url = $baseMediaUrl . $hero->id . '/';
            $path = $heroDir . $hero->id . '/';
            foreach($filesToGet as $type => $files){
                foreach($files as $k => $file){
                    if(stripos($file, '[x]') !== false){
                        // multiple files
                        if($type == 'avatars' || $type == 'icons'){
                            $start = 2;
                        }
                        if($type == 'abilities'){
                            $start = 1;
                        }
                        for($i = $start; $i < 20; $i++){
                            $newFile = str_replace('[x]',$i,$file);
                            if($this->checkIfFileExists($path . $newFile) == false){
                                $downloaded = $this->downloadFile($url . $newFile, $path);
                                if($downloaded == 'No file' || $downloaded == 'File not found'){
                                    echo 'Hero: ' . $hero->name . ' - File: ' . $newFile . ' - Status: Error ' . $downloaded . '<br>';
                                    $i = 20;
                                    continue;
                                } else {
                                    echo 'Hero: ' . $hero->name . ' - File: ' . $newFile . ' - Status: Downloaded ' . $downloaded . '<br>';
                                }
                            } else {
                                echo 'Hero: ' . $hero->name . ' - File: ' . $newFile . ' - Status: Skipped' . '<br>';
                            }
                        }
                    } else {
                        if($this->checkIfFileExists($path . $file) == false){
                            $downloaded = $this->downloadFile($url . $file, $path);
                            echo 'Hero: ' . $hero->name . ' - File: ' . $file . ' - Status: Downloaded ' . $downloaded . '<br>';
                        } else {
                            echo 'Hero: ' . $hero->name . ' - File: ' . $file . ' - Status: Skipped' . '<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkIfFileExists($file){
        if(!file_exists($file)){
            return false;
        } else {
            return true;
        }
    }
}
