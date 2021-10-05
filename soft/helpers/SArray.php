<?php 

	namespace soft\helpers;

	use yii\helpers\ArrayHelper;
	use yii\helpers\ReplaceArrayValue;

	/**
	 * @author Shukurullo Odilov
	 */
	class SArray extends ArrayHelper
	{

        /**
         * Berilgan array ichida $path bo'yicha element mavjud va uning qiymati
         * nullga teng bo'lmasa true qiymat qaytaradi
         * @param array $array
         * @param string $path  path to key which to be checked
         * @return boolean whether given path is valid
         */

        public static function keyValids($array, $path){

            $value = static::getValue($array, $path);
            return $value != null;

        }

	    /**
		* Agar berilgan $array da  $path `valid` bo'lmasa ([[SArray::keyValids()]]),
		* berlgan $arrayga shu $path elemntiga  $value ni o'rnatish
		*/

		public static function setValueIfNoValid(&$array, $path, $value){

		     if (!static::keyValids($array, $path) )  {
		     	static::setValue($array, $path, $value);
		     }
                     
		}



		/**
		 * Arraydagi keyni berilgan boshqa nomga replace qiladi
		*/

		public static function keyReplace(&$array, $oldKey, $newKey, $defaultValue = null){
		
		     if (isset($array[$oldKey]) ) {
		     	$array[$newKey] = $array[$oldKey];
		     	unset($array[$oldKey]);
		     }
		     else{
		     	$array[$newKey] = $defaultValue;
		     }
		        
		}

		/**
		 * [[ArrayHelper::merge()]] funksiyasidan foydalanishda arraylar ichidagi ba'zi arraylarni 
		 * 'merge' qilmasdan, 'replace' qilishda foydalaniladi. 
		 * Argument sifatida ikki yoki undan ortiq `merge` qilinadigan massivlar beriladi va 
		 * oxirgi argumet sifatida `replace` bo'ladigan massiv element(lar)i uchun `path` beriladi.
		 * `Path` ni string yoki massiv ko'rinishda berish mumkin.
		 * ```php
		 * $a = [
				'config' => [
					'config1' => 'config 1 A',
					'config2' => 'config 2 A',
					'colors' => [
						'color1' => 'red', 
						'color2' => 'blue', 
						'color3' => 'green',  
					] 
				],
			];
			$b = [
				'config' => [
					'config1' => 'config 1 B',
					'config3' => 'config 3 B',
					'colors' => [
						'color1' => 'yellow', 
						'color2' => 'blue', 
						'color4' => 'orange',  
					] 
				],
			];
		 * ```
		 * The result of `SArray::mergeReplace($a, $b, 'config.colors')` could be like the following:
	     *
	     * ```php
	     * [
				'config' => [
					'config1' => 'config 1 B',
					'config2' => 'config 2 A',
					'config3' => 'config 3 B',
					'colors' => [
						'color1' => 'yellow', 
						'color2' => 'blue', 
						'color4' => 'orange',  
					] 
				],
			];
	     * ```
		*/
		

		public static function mergeReplace($a, $b){

			 $args = func_get_args();
			 $repKey = static::removeLast($args); // replacement key (the last element of arguments)
			 $repKeys = [];
			 if (is_string($repKey)) {
			 	$repKeys[] = $repKey;
			 }
			 if (is_array($repKey)) {
			 	$repKeys = $repKey;
			 }

			 foreach ($args as $argKey => $argValue) {
			 	foreach ($repKeys as $key) {
				 	$path = $argKey.".".$key;
				 	if (static::keyIsset($args, $key)) {
					 	$value = new ReplaceArrayValue(static::getValue($args, $path));
                        static::setValue($args, $path, $value);
				 	}
				 }

			 }

			 $result = [];	
			 foreach ($args as $arg) {
			 	$result = static::merge($result, $arg);
			 }
			 return $result;
		}

		 /**
	     * Checks if the given array contains the specified key path.
	     * This method enhances the  [[ArrayHelper::keyExists()]] method by supporting dot format
	     * key path.
	     * @param string $key the key path to check  
	     * @param array $array the array with keys to check
	     * @return bool whether the array contains the specified key
	     */

		 public static function keyIsset($array, $path){

		 	$defaultValue = 'djkgjfsbvjgjrgfjfydsvblau';
		 	$value = static::getValue($array, $path, $defaultValue);
		 	// if $value == $defaultValue, it means  the array does not contain the specified key
		 	return $value != $defaultValue ;

		 }

		
		
		/**
		 * Remove the last item from array
		 * @return array removed item
		*/

		public static function removeLast(&$array){

			$last = end($array);
			$array = array_slice($array, 0, count($array)-1);
			return $last;

		}
		

	}

 ?>