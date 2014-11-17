<?php 
/**
* Klasa Basket_Container.
* @package basket
*/

/**
 * Klasa jest kontenerem - pozwala na przerzucanie $this w php w wersjach 5 i wy¿szych.
 * Konieczna jest taka kombinacja poniewa¿ starsze elementy koszyka pozostaj± niezmodyfikowane
 * a odwo³uj± siê one do globalnego (z ich punktu widzenia) obiektu $basket, 
 * który w tej chwili jest zale¿ny od kontekstu.
 *
 * Wykorzystanie - przy zalozeniu ze $x ma byc bierzacym obiektem:
 * $x = $this; // taka skladnia jest dozwolona
 * { //kod }
 * require_once ("./include/container.inc.php");
 * $containter =& new Basket_Container;
 * $container->me=& $this;
 * $container->me=$x;
 *
 * @author lukasz@sote.pl
 * @package basket
 * @since 03.11.05-cvs
 * @version $Id: container.inc.php,v 2.2 2006/02/09 10:43:15 maroslaw Exp $
 */
class Basket_Container {
	/**
	 * Obiekt docelowy
	 *
	 * @var object
	 */
	var $me;
}
?>