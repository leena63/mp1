<?php

main::start("data.csv");

class main
{
    static public function start($filename)
    {
        $data = csv::getdata($filename);
        $tables = html::buildtable($data);
        system::printPage($tables);
    }
}
class csv
{
    public static function getdata($filename)
    {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record=fgetcsv($file);
            if($count==0)
            {
                $fieldNames = $record;
                $data[] = recordFactory::create($fieldNames, $fieldNames);
            }
            else
            {
                $data[] = recordFactory::create($fieldNames,$record);
            }
            $count++;
        }
        fclose($file);
        return $data;
    }
}


class record
{
    public function __construct(Array $fieldNames = null , $values = null)
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function ReturnArray()
    {
        $array= (array) $this;
        return $array;
    }
    public function createProperty($name = 'street', $value = '3562 HIGH ST')
    {
        $this->{$name} = $value;
    }
}

class recordFactory
{
    public static function create(Array $fieldnames = null, Array $values = null)
    {
        $record=new record($fieldnames , $values);
        return $record;
    }
}
class html
{
    public static function buildtable($data)
    {
        $table = '<table border="1">';
        $table .= row::tableRow($data);
        $table .= '</table>';
        return $table;
    }
}

class row
{
    public static function tableRow($data)
    {
        $i=0;
        $flag = true;
        $table = "";
        foreach ($data as $key => $value)
        {
            $table .= "<tr class= \"<?=($i++%2==1) ? 'odd'  : ''; ?>\">";
            foreach ($value as $key2 => $value2)
            {
                if($flag)
                {
                    $table .= "<th>".htmlspecialchars($value2)."</th>";

                }
                else
                {
                    $table .= '<td>' . htmlspecialchars($value2) . '</td>';
                }
            }
            $flag = false;
            $table .= "</tr>";
        }
        return $table;

    }
}

class tableFactory
{
    public static function build(Array $row = null, Array $values = null)
    {
        $table = new table($row , $values);
        return $table;
    }
}



class system
{
    public static function printPage($page)
    {
        echo $page;
    }
}
