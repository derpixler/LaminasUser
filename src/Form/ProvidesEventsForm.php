<?php
/**
 * LaminasUser
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license AGPL-3.0 <https://www.gnu.org/licenses/agpl-3.0.en.html>
 */
namespace LaminasUser\Form;

use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\Form\Form;

class ProvidesEventsForm extends Form
{
    use EventManagerAwareTrait;
}
