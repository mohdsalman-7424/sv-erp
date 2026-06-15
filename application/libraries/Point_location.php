<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

/**
 * Check Latitude and Longitude exist in any bounded area in google map.
 *
 * @package			Custom
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Pradeep Kumar
 * @license			MIT License
 * 
 */

// Check if the point sits exactly on one of the vertices?
class Point_location {
    public $pointOnVertex = true;

    public function check_location($latitude, $longitude) {
    	
    	$latitude 	= trim($latitude);
 	   	$longitude 	= trim($longitude);
		$point 		= $latitude." ".$longitude;
		$addr_coards= $latitude.",".$longitude;
        $allstores 	= get_Store_Namess();
		$store_id 	= 0;
		$distance 	= 0;
        foreach ($allstores as $key => $allstore) {

        	$polygon = $this->decodePolygonLatLang($allstore->google_coordinate);
        	if($this->pointInPolygon($point, $polygon) == 'inside')
        	{
        		if($store_id == '')
        		{
	        		$store_id = $allstore->store_id;
	        		$distance = __get_distance($allstore->coords, $addr_coards);
	        		// pr($allstore->coords); echo "<br>"; pr($addr_coards);die;
        		}
        	}
        }
        return ['store_id'=>$store_id,'distance'=>$distance];
    }
 	
 	public function decodePolygonLatLang($data)
    {
        $crdData = [];
        if(!empty($data)){
            $data1 = explode("|",$data);
            $crd = explode(")",$data1[0]);
            for ($i=0; $i < count($crd)-1; $i++) { 
                $crd1 = ltrim($crd[$i],"(");
                $onebyone = explode(",",$crd1);
                $crdData[] = trim($onebyone[0])." ".trim($onebyone[1]);
            }
            return $crdData;

        }else{
            return '';
        }
    }

    public function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        // pr($polygon);die;
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 		// pr($vertices);die;
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    public function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }
 	
    public function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    	// pr($pointString);die;
    }

    public function testme()
    {
    	echo "Testme fucntion from Point_location class";
    }

}
