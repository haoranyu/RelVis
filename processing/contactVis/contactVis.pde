/* JS INTEGRATION
 * ============================================================ */
// credit: http://processingjs.nihongoresources.com/interfacing/

interface JavaScript {
  int getSent(int contactId);
  int getReceived(int contactId);
  boolean getOn(int contactId);
  String getLabel(int contactId);
  Object[] getContactsByMostTraffic();
}

JavaScript js = null;

void setJavaScript(JavaScript jsP) {
  js = jsP;
}

// endcredit


/* GLOBAL VARIABLES
 * ============================================================ */
// constants
color backgroundColor = color(228,227,223,100);
int time = 20;
PVector center;
int buffer = 50;

int radius = 640;
int padding = 600;

// js inputs
// MUST BE SET FIRST
// int numContacts

// objects
Contact you;
Contact[] contacts;


/* DRAWING FUNCTIONS
 * ============================================================ */

/* Setup
 * ------------------------------------------------------------ */
void setup() {
  // display
  size(radius + padding, radius + padding);
  smooth();
  background(backgroundColor);
  
  // variables
  center = new PVector(0, 0);
  
  // objects
  color yourColor = color(5, 5, 250);
  you = new Contact(
    /* id = */ -1,
    /* stroke color = */ yourColor,
    /* fill color = */ yourColor,
    /* size = */ 24,
    /* start location = */ center.get(),
    /* angle = */ new PVector(0, 0)
  );
  
  // place each contact in center w/ default size
  contacts = new Contact[numContacts];
  for (int i = 0; i < numContacts; i++) {
    // PVector.fromAngle not implemented in processing.js
    // PVector angle = PVector.fromAngle(PI * 2 / numContacts * i);
    PVector angle = new PVector((float) Math.cos(PI * 2 / numContacts * i),
                                (float) Math.sin(PI * 2 / numContacts * i));
    PVector start = angle.get();
    int magnitude = 0;
    start.mult(magnitude);

    contacts[i] = new Contact(
      /* id = */ i,
      /* stroke color = */ color(0, 20),
      /* fill color = */ color(0, 20),
      /* size = */  16,
      /* start location = */ start,
      /* angle = */ angle
    );

  }

}

/* Draw
 * ------------------------------------------------------------ */
void draw() {
  // clean the canvas
  fill(backgroundColor);
  rect(0, 0, (radius+padding)*2, (radius+padding)*2);

  translate((radius+padding)/2, (radius+padding)/2);
  drawLimit(buffer);
  drawLimit(radius);
  you.display();

  for (int i = 0; i < numContacts; i++) {
    contacts[i].next();
    if (contacts[i].on) {
      contacts[i].display();
    }
  }
  

  
  if (frameCount % time == 0) {
    updateContacts();
  }
}

void drawLimit(diameter) {
    // show current iteration
    ellipseMode(CENTER);
    stroke(190, 190, 190);
    noFill();
    ellipse(center.x, center.y, diameter, diameter);
}


/* HELPER FUNCTIONS
 * ============================================================ */
 
/* contacts[] Helper Functions
 * ------------------------------------------------------------ */
void advanceContacts() {
  for (int i = 0; i < numContacts; i++) {
    contacts[i].next();
  }
}

// get size + velocity from JS
void updateContacts() {
  int[] positions = new int[numContacts];
  int largestPos = 0;
  int smallestPos = MAX_INT;

  int[] sizes = new int[numContacts];
  int largestSize = 0;
  int smallestSize = MAX_INT;

  int[] contactTotals = new int[numContacts];
  int largestTotal = 0;
  int smallestTotal = MAX_INT;
  
  // get info and find ranges
  for (int i = 0; i < numContacts; i++) {
    Contact c = contacts[i];
    
    int curPos = (int) js.getSent(i);
    positions[i] = curPos;
    if (curPos > largestPos) {
      largestPos = curPos;
    }
    if (curPos < smallestPos) {
      smallestPos = curPos;
    }

    int curSize = (int) js.getReceived(i);
    sizes[i] = curSize;
    if (curSize > largestSize) {
      largestSize = curSize;
    }
    if (curSize < smallestSize) {
       smallestSize = curSize;
    }

    int curTotal = curPos + curSize;
    contactTotals[i] = curTotal;
    if (curTotal > largestTotal) {
      largestTotal = curTotal;
    }
    if (curTotal < smallestTotal) {
      smallestTotal = curTotal;
    }

    c.sent = curPos;
    c.received = curSize;
  }

  for (int i = 0; i < numContacts; i++) {
    Contact c = contacts[i];
    
    // position
    // js.console.log(smallestTotal + ", " + largestTotal + ", " + contactTotals[i]);
    int pos = normalize(
      positions[i],
      smallestPos,
      largestPos,
      c.magLowerLimit,
      c.magUpperLimit
    );
    c.updatePosition( pos );

    // size
    // js.console.log(smallestTotal + ", " + largestTotal + ", " + contactTotals[i]);
    int size = normalize(
      sizes[i],
      smallestSize,
      largestSize,
      c.sizeLowerLimit,
      c.sizeUpperLimit
    );
    c.updateSize( size );
    
    // color
    // js.console.log(i + ", " + smallestTotal + ", " + largestTotal + ", " + contactTotals[i]);
    int lower = 100;
    int upper = 225;
    int b = normalize(
      contactTotals[i],
      smallestTotal,
      largestTotal,
      lower,
      upper
    );
    int g = normalize(
      positions[i],
      smallestPos,
      largestPos,
      lower,
      upper
    );
    int r = normalize(
      sizes[i],
      smallestSize,
      largestSize,
      lower,
      upper
    );
    c.fillColor = color(r, g, b, 100);

    // on / off
    c.on = js.getOn(i); // TODO: make into bool (js sometimes gives string)
  }

}

void highlightContact(int contactId) {
  contacts[contactId].highlight = true;
}

void unHighlightContact(int contactId) {
  contacts[contactId].highlight = false;
}

/* Math Helper Functions
 * ------------------------------------------------------------ */
// normalize
//  - [smallestPos...largestPos] to [lower...upper]
//  - http://stackoverflow.com/questions/1471370/normalizing-from-0-5-1-to-0-1
//     - see the last answer
//
//  1. shift the range to [0...x] via subtraction
//  2. scale the range to [0...1] via division
//  3. scale the range to [0...D-C] via multiplication
//       so it has the length of the new range (D-C)
//  4. shift the range to [C...D] via addition
int normalize(int n, int fromLow, int fromHigh, int toLow, int toHigh) {
  if (n < fromLow || n > fromHigh) {
    return -1;
  }

  n -= fromLow;
  n /= (fromHigh - fromLow); // from length
  n *= (toHigh - toLow); // to length
  n += toLow;

  return n;
}
