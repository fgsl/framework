<?php
/**
 *  FGSL Framework
 *  @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 *  @copyright FGSL 2020
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
declare(strict_types = 1);
namespace Fgsl\View;

use Laminas\View\Helper\HeadScript;
use Laminas\View\Renderer\RendererInterface;

class JSHelper
{
    /** @var string */
    public static $script;
    
    /**
     * @param RendererInterface $view
     * @param string $path
     * @param array $paths
     * @param boolean $constants
     */
    public static function loadJS(RendererInterface $view, string $path = null, array $paths = null,$constants = true, $type = 'text/javascript')
    {
        if ($constants){
            $view->headScript(HeadScript::SCRIPT)->appendScript(self::$script, $type);
        }
        if ($paths == null){
            $script = file_get_contents($path);
            $view->headScript(HeadScript::SCRIPT)->appendScript($script, $type);
        } else {
            foreach($paths as $path){
                $script = file_get_contents($path);
                $view->headScript(HeadScript::SCRIPT)->appendScript($script, $type);
            }
        }
    }
    
    /**
     * @param RendererInterface $view
     * @param string $path
     */
    public static function appendJS(RendererInterface $view, string $path, $type = 'text/javascript')
    {
        $view->headScript(HeadScript::FILE)->appendFile($path, $type);
    }
    
    /**
     * @param RendererInterface $view
     * @param string $path
     */
    public static function prependJS(RendererInterface $view, string $path, $type = 'text/javascript')
    {
        $view->headScript(HeadScript::FILE)->prependFile($path, $type);
    }
    
    /**
     * @param RendererInterface $view
     * @param string $script
     */
    public static function appendScript(RendererInterface $view, string $script, $type = 'text/javascript')
    {
        $view->headScript(HeadScript::SCRIPT)->appendScript($script, $type);
    }
    
    /**
     * @param RendererInterface $view
     * @param string $script
     */
    public static function prependScript(RendererInterface $view, string $script, $type = 'text/javascript')
    {
        $view->headScript(HeadScript::SCRIPT)->prependScript($script, $type);
    }
}
