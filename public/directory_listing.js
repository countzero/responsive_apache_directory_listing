/**
 * directory_listing.js
 * 
 * @copyright Copyright (c) 2014 Finn Rudolph (http://finnrudolph.de)
 * @license   http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
 * @author    Finn Rudolph <finn.rudolph@gmail.com>
 */

/**
 * Module - Directory Listing
 * 
 * The module is wrapped in a self calling anonymous function.
 * It injects the namespace dependency: 
 * 
 *     window.finnrudolph > namespace
 * 
 * The anonymous function creates an new object 
 * and attaches it to the passed namespace object.  
 */
window.finnrudolph = (function(namespace, Core) 
{
    'use strict'; 
    
    /**
     * Dom Ready
     *
     * @memberOf DomReady
     * @private
     * @constructor
     */
    var DomReady = function()
    {
        /**
         * Is ready
         * 
         * @memberOf DomReady
         * @private
         */
        var _isReady = false;
        
        /**
         * Queue
         * 
         * @memberOf DomReady
         * @private
         */
        var _queue = [];
        
         /**
         * Initialize
         * 
         * @memberOf DomReady
         * @function
         * @public
         */
        this['initialize'] = function()
        {
            /* If the DOMContentLoaded event is supported */
            if(document.addEventListener)
            {
                /* Bind run to the DOMContentLoaded event */
                document.addEventListener('DOMContentLoaded', _ready, false);
    
                /* Fallback to the load event */
                window.addEventListener('load', _ready, false);
            }
    
            /* If the Internet Explorer event model is used */
            if(document.attachEvent)
            {
                /* Bind run to the onreadystatchange event */
                document.attachEvent('onreadystatechange', _ready);
                
                /* Fallback to the window.onload event */
                window.attachEvent('onload', _ready);
            }
        };
        
        /**
         * Add
         * 
         * @memberOf DomReady
         * @function
         * @public
         */
        this['add'] = function(callback)
        {
            if(_isReady)
            {
                callback();
                return;
            }
            
            var index = _queue.length;
            while(index--)
            {
                if(callback === _queue[index])
                {
                    return;
                }
            }
            
            _queue.push(callback);
        };
        
        /**
         * Ready
         * 
         * @memberOf DomReady
         * @function
         * @private
         */
        var _ready = function()
        {
            if(_isReady === false)
            {
                _isReady = true;
                _run();
            }
        };
        
        /**
         * Run
         * 
         * @memberOf DomReady
         * @function
         * @private
         */
        var _run = function()
        {            
            var count = _queue.length,
                index;
            
            for(index = 0; index < count ; index++)
            {
                _queue[index]();
            }
        };
    };
    
    /**
     * Directory Listing
     *
     * @memberOf DirectoryListing
     * @private
     * @constructor
     */
    var DirectoryListing = function()
    {
        /**
         * Setup Icons
         * 
         * Sets the data-icon attribute to the icon cell based on the alt attribute of the replaced image.
         *
         * @memberOf DirectoryListing
         * @function
         * @private
         */
        var _setupIcons = function()
        {
            var images = document.getElementsByTagName('img'),
                index = images.length;
            
            while(index--)
            {
                images[index].parentNode.setAttribute('data-icon', images[index].getAttribute('alt'));
            }
        };
        
        /**
         * Table Row Click Handler
         * 
         * A click anywhere on a row changes the browser location to the link target.
         *
         * @memberOf DirectoryListing
         * @function
         * @private
         */
        var _tableRowClickHandler = function()
        {
            var rows = document.getElementsByTagName('tr'),
                max = rows.length,
                index;
            
            for(index = 1; index < max; index++)
            {
                rows[index].onclick = function(event)
                {
                    location.href = this.getElementsByTagName('a')[0].getAttribute('href');
                }
            }
        };
        
        /**
         * Deny Access Outside Root Path
         * 
         * Hide the ' .. Parent Directory ' row if the user is on the root level.
         *
         * @memberOf DirectoryListing
         * @function
         * @private
         */
        var _denyAccessOutsideRootPath = function()
        {
            if(window.location.pathname === document.getElementById('root').getAttribute('href'))
            {
                document.getElementsByTagName('tr')[1].style.cssText = 'display:none;';
            }
        };
        
        /**
         * Initialize
         * 
         * @memberOf DirectoryListing
         * @function
         * @public
         */
        this['initialize'] = function()
        {
            namespace.DomReady.add(_setupIcons);
            namespace.DomReady.add(_tableRowClickHandler);
            namespace.DomReady.add(_denyAccessOutsideRootPath);
        }; 
    };
    
    /* Attach a new DomReady object to the namespace and initialize it */
    namespace.DomReady = new DomReady();
    namespace.DomReady.initialize();

    /* Create a new DirectoryListing object and initialize it */
    var directoryListing = new DirectoryListing();
    directoryListing.initialize();

    /* Return the namespace object */
    return namespace;

}(window.finnrudolph || {}));
