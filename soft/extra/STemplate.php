<?php 

	namespace soft\extra;

	use Yii;
	use yii\web\View;
	use soft\helpers\SArray;
	use soft\base\SWidgetBase;


	/**
	 * Render items based on given template
	*/

	/**
	 * @author: Shukurullo Odilov
	 */

	class STemplate extends SWidgetBase
	{
		/**
		 * @var template is the template of the items
		*/
		
		public $template = -1;

		public $items = [];

		public $separator = '';

		public function main(){

			$this->html = $this->renderItems();
		        
		}

		public function renderItems(){

		    if ($this->template == false) {
				return false;
			}
			elseif ($this->template === -1) {
				$result = "";
				foreach ($this->items as $key => $value) {
					$result .= $value.$this->separator;
				}
				return $result;
			}
			else{
				$result = $this->template;
				foreach ($this->items as $key => $value) {
					$result = strtr($result, [
						"{{$key}}" => $value
					]);
				}
				return $result;
			}
		}
	}


 ?>