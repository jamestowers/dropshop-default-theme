# IE8 ployfill for GetComputed Style (for Responsive Script below)
unless window.getComputedStyle
  window.getComputedStyle = (el, pseudo) ->
    @el = el
    @getPropertyValue = (prop) ->
      re = /(\-([a-z]){1})/g
      prop = "styleFloat"  if prop is "float"
      if re.test(prop)
        prop = prop.replace(re, ->
          arguments_[2].toUpperCase()
        )
      (if el.currentStyle[prop] then el.currentStyle[prop] else null)

    this

# as the page loads, call these scripts

window.sizes = 
  windowWidth: $(window).width()
  windowHeight: $(window).height()
window.isMobile = window.sizes.windowWidth < 580

$doc = $(document)

$doc.on 'click', 'a#menu-toggle', ->
  console.log 'aergwtg'
  $('#wrapper').toggleClass 'slide-left'
  false

# if is below 481px 
#dothis()  if responsive_viewport < 481
# end smallest screen 

# if is larger than 481px 
#dothis()  if responsive_viewport > 481
# end larger than 481px 

# if is above or equal to 768px 
#dothis() if responsive_viewport >= 768

# off the bat large screen actions 
#dothis()  if responsive_viewport > 1030




$(window).scroll ->
  unless window.isMobile
    if $(window).scrollTop() > 142
      $('body').addClass 'scrolled'
    else
      $('body').removeClass 'scrolled'

$(window).resize ->
  checkWidths()




# end of as page load scripts 






#! A fix for the iOS orientationchange zoom bug.
# Script by @scottjehl, rebound by @wilto.
# MIT License.
#
((w) ->
  
  # This fix addresses an iOS bug, so return early if the UA claims it's something else.
  restoreZoom = ->
    meta.setAttribute "content", enabledZoom
    enabled = true
    return
  disableZoom = ->
    meta.setAttribute "content", disabledZoom
    enabled = false
    return
  checkTilt = (e) ->
    aig = e.accelerationIncludingGravity
    x = Math.abs(aig.x)
    y = Math.abs(aig.y)
    z = Math.abs(aig.z)
    
    # If portrait orientation and in one of the danger zones
    if not w.orientation and (x > 7 or ((z > 6 and y < 8 or z < 8 and y > 6) and x > 5))
      disableZoom()  if enabled
    else restoreZoom()  unless enabled
    return
  return  unless /iPhone|iPad|iPod/.test(navigator.platform) and navigator.userAgent.indexOf("AppleWebKit") > -1
  doc = w.document
  return  unless doc.querySelector
  meta = doc.querySelector("meta[name=viewport]")
  initialContent = meta and meta.getAttribute("content")
  disabledZoom = initialContent + ",maximum-scale=1"
  enabledZoom = initialContent + ",maximum-scale=10"
  enabled = true
  x = undefined
  y = undefined
  z = undefined
  aig = undefined
  return  unless meta
  w.addEventListener "orientationchange", restoreZoom, false
  w.addEventListener "devicemotion", checkTilt, false
  return
) this