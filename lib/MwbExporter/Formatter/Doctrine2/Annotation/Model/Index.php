<?php
/*
 * The MIT License
 *
 * Copyright (c) 2010 Johannes Mueller <circus2(at)web.de>
 * Copyright (c) 2012 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MwbExporter\Formatter\Doctrine2\Annotation\Model;

use MwbExporter\Model\Index as BaseIndex;
use MwbExporter\Formatter\Doctrine2\Annotation\Formatter;

class Index extends BaseIndex
{
    protected function getColumnNames()
    {
        $columnNameCodingStyle = $this->getDocument()->getConfig()->get(Formatter::CFG_COLUMN_NAME_CODING_STYLE);

        $columns = array();
        foreach ($this->columns as $refColumn) {
            $columns[] = $refColumn->getColumnName($columnNameCodingStyle);
        }

        return $columns;
    }

    public function asAnnotation()
    {
        $columnNameCodingStyle = $this->getDocument()->getConfig()->get(Formatter::CFG_COLUMN_NAME_CODING_STYLE);

        switch ($columnNameCodingStyle) {
            case 'raw':
                $name = $this->parameters->get('name');
                break;
            case 'lowercamelcase':
                $name = $this->formatLowerCamelCase($this->parameters->get('name'));
                break;
            case 'uppercamelcase':
                $name = $this->formatUpperCamelCase($this->parameters->get('name'));
                break;
            case 'underscore':
                $name = $this->formatUnderscore($this->parameters->get('name'));
                break;
        }

        return array('name' => $name, 'columns' => $this->getColumnNames($columnNameCodingStyle));
    }
}