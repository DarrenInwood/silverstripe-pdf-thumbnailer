<?php

// PDF Thumbnailer extension for File class
// Use $file->Thumbnail($page) to return an Image representing the given page of
// a PDF file.  If no page is given, the first is used.  If the file can't be
// thumbnailed, false is returned.
// Uses ImageMagick.

Object::add_extension('File', 'PdfThumbnailerExtension');

