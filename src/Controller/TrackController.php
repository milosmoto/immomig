<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Model\Map;
use App\Model\Point;
use App\Model\Trk;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Class TrackController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 */
class TrackController extends AbstractController
{
    /**
     * @Route("/track", name="track")
     */
    public function index()
    {
        //TODO implement pagination
        $tracks = $this->getDoctrine()->getRepository(Track::class)->findAll();

        return $this->render('track/index.html.twig', [
            'tracks' => $tracks
        ]);
    }

    /**
     * @Route("/track/new", name="track_new")
     */
    public function create(Request $request)
    {
        $track = new Track();
        $track->setUser($this->getUser());
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded GPX file
            /** @var UploadedFile $file */
            $file = $track->getMap();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where maps are stored
            try {
                $file->move(
                    $this->getParameter('map_directory'),
                    $fileName
                );
            } catch (FileException $e) {
            }

            $track->setMap($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($track);
            $em->flush();

            return $this->redirectToRoute('track');
        }

        return $this->render('track/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/track/{id}", name="track_view")
     * @ParamConverter("track", class="App:Track")
     */
    public function view(Track $track, SerializerInterface $serializer)
    {
        $xml = file_get_contents($this->getParameter('map_directory') . DIRECTORY_SEPARATOR . $track->getMap());

        /** @var Map $map */
        $map = $serializer->deserialize($xml, Map::class, 'xml');

        $points = [];
        $latSum = 0;
        $lonSum = 0;
        /** @var Point $point */
        foreach ($map->getTrk()->getPoints() as $point) {
            $points[] = [$point->getLat(), $point->getLon()];
            $latSum += $point->getLat();
            $lonSum += $point->getLon();
        }

        return $this->render('track/view.html.twig', [
            'track' => $track,
            'points' => $points,
            'latAverage' => $latSum / count($points),
            'lonAverage' => $lonSum / count($points)
        ]);
    }
}
