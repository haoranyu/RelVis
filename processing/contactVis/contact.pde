/* CONTACT CLASS
 * ============================================================ */
 
// New contact declaration boilerplate:
// Contact chewbacca = new Contact(
//   /* int = */ id,
//   /* stroke color = */ color,
//   /* fill color = */ color,
//   /* size = */ float,
//   /* start location = */ PVector,
//   /* angle = */ PVector
// );
 
class Contact {
  
/* Class Variables
 * ------------------------------------------------------------ */
  // contact info
  int id;
  int sent = 0;
  int received = 0;

  // drawing
  boolean on;
  boolean highlight;
  color strokeColor;
  color fillColor;
  color highlightColor;
  
  // location + movement
  PVector at;
  PVector angle; // a unit vector to move the contact along
  PVector velocity;
  float magLowerLimit = buffer;
  float magUpperLimit = radius/2;
  
  // size + resize
  float size;
  float resizeRate;
  float sizeLowerLimit = radius/70;
  float sizeUpperLimit = radius/7;
  
/* Constructors
 * ------------------------------------------------------------ */
  Contact(int idP, color strokeP, color fillP, float sizeP, PVector startP, PVector angleP) {
    // contact info
    id = idP;

    // drawing
    on = true;
    highlight = false;
    strokeColor = strokeP;
    fillColor = fillP;
    highlightColor = color(255, 0, 0, 75);
    
    // location + movement
    at = startP.get();
    angle = angleP;
    updatePosition(0); // sets velocity
    
    // size + resize
    size = sizeP;
    updateSize(0); // sets resizeRate
  }
  
/* Functions - Update Contact
 * ------------------------------------------------------------ */
  void updatePosition(float toP) {    
    velocity = angle.get();
    velocity.mult((toP - at.mag()) / time);
  }
  
  void updateSize(float resizeToP) {
    resizeRate = (resizeToP - size) / time;
  }

/* Functions - Advance State
 * ------------------------------------------------------------ */
  void next() {
    move();
    resize();
  }
  
  void move() {
    at.add(velocity);
    
    // lower location bound
    if (at.mag() < magLowerLimit) {
      at.set(angle.get());
      at.mult(magLowerLimit);
      updatePosition(magLowerLimit);
    }

    // upper location bound
    if (at.mag() > magUpperLimit) {
      at.set(angle.get());
      at.mult(magUpperLimit);
      updatePosition(magUpperLimit);
    }
  }
  
  void resize() {
    size += resizeRate;
    
    // lower size bound
    if (size < sizeLowerLimit) {
      size = sizeLowerLimit;
      updateSize(sizeLowerLimit);
    }
    
    // upper size bound
    if (size > sizeUpperLimit) {
      size = sizeUpperLimit;
      updateSize(sizeUpperLimit);
    }
  }

/* Functions - Drawing
 * ------------------------------------------------------------ */
  void display() {
    if (on == "false") {
      return;
    }

    // inverse our distances from center: more frequent = closer
    PVector from = angle.get();
    from.mult( radius/2 + buffer - at.mag() );

    ellipseMode(CENTER);
    // noStroke();
    stroke(strokeColor);
    fill(fillColor);
    
    if (highlight) {
      doHighlight();
    }
    
    ellipse(from.x, from.y, size, size);

  }
  
  void doHighlight() {
    // inverse our distances from center: more frequent = closer
    PVector from = angle.get();
    from.mult( radius/2 + buffer - at.mag() );
    
    String label = js.getLabel(id) + " (send=" + sent + ", rec=" + received + ")";
    textSize(12);
    fill(0);
    text(label, from.x + size/2 + 5, from.y + 6);
    
    fill(highlightColor);
  }

}
